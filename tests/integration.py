#!/usr/bin/env python3
"""Real isolated MariaDB/PHP HTTP integration. Synthetic data only, processes cleaned in finally."""
import os,pathlib,subprocess,socket,tempfile,time,shutil,urllib.request,urllib.error,urllib.parse,http.cookiejar,re,json,base64
ROOT=pathlib.Path(__file__).resolve().parents[1]
class Client:
 def __init__(self,url):
  self.url=url;self.jar=http.cookiejar.CookieJar();self.op=urllib.request.build_opener(urllib.request.HTTPCookieProcessor(self.jar));self.csrf=''
 def req(self,path,data=None,raw=None,ctype=None):
  if data is not None:raw=urllib.parse.urlencode(data,doseq=True).encode()
  req=urllib.request.Request(self.url+path,data=raw,headers={'Content-Type':ctype or 'application/x-www-form-urlencoded'} if raw is not None else {})
  try:r=self.op.open(req,timeout=20)
  except urllib.error.HTTPError as ex:r=ex
  body=r.read();m=re.search(rb'name="csrf" value="([a-f0-9]+)"',body)
  if m:self.csrf=m[1].decode()
  return r.code,body,r.headers
 def post(self,path,data):return self.req(path,{'csrf':self.csrf,**data})
 def upload(self,name,payload,token=True,path='subir_imagen.php'):
  b='BOUNDARYsecuretest';raw=b''
  if token:raw+=f'--{b}\r\nContent-Disposition: form-data; name="csrf"\r\n\r\n{self.csrf}\r\n'.encode()
  raw+=f'--{b}\r\nContent-Disposition: form-data; name="userfile"; filename="{name}"\r\nContent-Type: image/png\r\n\r\n'.encode()+payload+f'\r\n--{b}--\r\n'.encode()
  return self.req(path,raw=raw,ctype='multipart/form-data; boundary='+b)
def main():
 runtime=pathlib.Path(tempfile.mkdtemp(prefix='.test-runtime-',dir=ROOT));procs=[];files=[];results=[];created_uploads=[];env_replaced=False
 def check(label,condition):
  results.append({'test':label,'pass':bool(condition)});print(('PASS ' if condition else 'FAIL ')+label)
  if not condition:raise AssertionError(label)
 try:
  datadir=runtime/'db';sock=str(runtime/'mysql.sock')
  with open(runtime/'bootstrap.log','w') as log:
   subprocess.run(['mariadb-install-db','--no-defaults',f'--datadir={datadir}','--auth-root-authentication-method=normal','--skip-test-db'],stdout=log,stderr=log,check=True)
  log=open(runtime/'db.log','w');files.append(log)
  db=subprocess.Popen(['mariadbd','--no-defaults','--user=root',f'--datadir={datadir}',f'--socket={sock}',f'--pid-file={runtime}/db.pid','--skip-networking','--innodb-buffer-pool-size=32M'],stdout=log,stderr=log);procs.append(db)
  def sql(query):return subprocess.check_output(['mariadb','--no-defaults','--socket='+sock,'-uroot','--batch','--skip-column-names'],input=query.encode()).decode().strip()
  for _ in range(100):
   if pathlib.Path(sock).exists():
    try:sql('SELECT 1');break
    except subprocess.CalledProcessError:pass
   time.sleep(.1)
  sql('CREATE DATABASE asistencia_test CHARACTER SET utf8mb4;')
  sql('USE asistencia_test;'+(ROOT/'database/install.sql').read_text())
  env={k:v for k,v in os.environ.items() if not k.startswith(('DB_', 'APP_CONFIG'))}
  env['APP_TMP']=str(runtime/'pdf')
  # Preserve an existing .env byte-for-byte without reading or logging it.
  if (ROOT/'.env').exists(): (ROOT/'.env').rename(runtime/'original.env')
  env_replaced=True
  (ROOT/'.env').write_text(f"DB_SOCKET='{sock}'\nDB_NAME=asistencia_test\nDB_USER=root\nDB_PASS=''\n")
  def query(s):return sql('USE asistencia_test;'+s)
  passwd='Test-only-Secure-937!'
  hashed=subprocess.check_output(['php','-r','echo password_hash(stream_get_contents(STDIN),PASSWORD_DEFAULT);'],input=passwd.encode()).decode()
  query("INSERT INTO usuarios(nombre,usuario,password,email) VALUES ('Prueba','testadmin','"+hashed+"','test@example.invalid');")
  s=socket.socket();s.bind(('127.0.0.1',0));port=s.getsockname()[1];s.close()
  log=open(runtime/'php.log','w');files.append(log)
  proc=subprocess.Popen(['php','-S',f'127.0.0.1:{port}','-t',str(ROOT)],env=env,stdout=log,stderr=log);procs.append(proc)
  url=f'http://127.0.0.1:{port}/'
  for _ in range(100):
   try:urllib.request.urlopen(url+'login.php');break
   except Exception:time.sleep(.05)
  admin=Client(url);admin.req('login.php')
  check('login CSRF rejected',admin.req('login.php',{'usuario':'testadmin','contrasena':passwd})[0]==403)
  check('admin bad password rejected',admin.post('login-adm.php',{'usuario':'testadmin','contrasena':'incorrect'})[0]==401)
  check('historical jose bypass rejected',admin.post('login-adm.php',{'usuario':'jose','contrasena':'anything'})[0]==401)
  check('login SQLi rejected',admin.post('login.php',{'usuario':"' OR 1=1 -- ",'contrasena':passwd})[0]==401)
  before=[c.value for c in admin.jar if c.name=='PHPSESSID'];code,body,_=admin.post('login.php',{'usuario':'testadmin','contrasena':passwd})
  check('admin login + session regeneration',code==200 and before!=[c.value for c in admin.jar if c.name=='PHPSESSID'] and b'BIENVENIDO' in body)
  check('CRUD CSRF rejected',admin.req('curso.php',{'nuevo':'1','nombre':'invalid'})[0]==403)
  for page in ['alumno','curso','grupo','matricula','configuraciones','asistencia']:
   code,body,_=admin.req(page+'.php');check('admin page '+page,code==200 and b'Error interno' not in body)
  # original field contract is intentionally retained
  student={'accion':'guardar','nombre':'<script>test</script>','apellido':"O'Prueba",'cedula':'TEST001','telefono_alumno':'1','nascimiento':'01/01/2000','email':'a@example.invalid','direcion':'Calle','ciudad':'Prueba','ruc':'','razonsocial':'','nombreref':'','telefonoref':'','nombremama':'','telefono_mama':'','nombrepapa':'','telefono_papa':'','contrasena':passwd,'estado':'activo','foto':''}
  admin.post('alumno.php',student)
  aid=query("SELECT id FROM alumnos WHERE cedula='TEST001'");check('create alumno with password_hash',aid.isdigit() and query('SELECT password FROM alumnos WHERE id='+aid).startswith('$2y$'))
  code,body,_=admin.req('alumno.php');check('stored XSS escaped',b'&lt;script&gt;test&lt;/script&gt;' in body and b'<script>test</script>' not in body)
  student.update(accion='actualizar',codigo=aid,nombre='Alumno Prueba',contrasena='');admin.post('alumno.php',student);check('update alumno',query('SELECT nombre FROM alumnos WHERE id='+aid)=='Alumno Prueba')
  course={'nuevo':'1','nombre':"Danza ' segura",'descripcion':'Resumen','detallada':'Detalle','duracion':'12','estado':'1','cuota':'100','matricula':'20'}
  admin.post('curso.php',course);cid=query('SELECT id FROM cursos LIMIT 1');check('create curso quoted value',cid.isdigit())
  course.pop('nuevo');course.update(guardar='1',codigo=cid,nombre='Curso actualizado');admin.post('curso.php',course);check('update curso',query('SELECT nombre FROM cursos WHERE id='+cid)=='Curso actualizado')
  day=query("SELECT ELT(DAYOFWEEK(CURRENT_DATE()),'Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado')")
  group={'nuevo':'1','curso':cid,'descripcion':'Grupo prueba','dia[]':[day],'entrada':'00:00','salida':'23:59','estado':'1'}
  admin.post('grupo.php',group);gid=query('SELECT id FROM grupos LIMIT 1');check('create grupo + horario',gid.isdigit() and query('SELECT COUNT(*) FROM horarios')=='1')
  code,body,_=admin.req('matricula.php');check('matricula GET with existing group',code==200 and b'Grupo prueba' in body and b'Error interno' not in body)
  group.pop('nuevo');group.update(guardar='1',codigo=gid,descripcion='Grupo actualizado');admin.post('grupo.php',group);check('update grupo + horario',query('SELECT descripcion FROM grupos WHERE id='+gid)=='Grupo actualizado')
  enrollment={'nuevo':'1','alumno':aid,'grupo':gid,'fechainicio':'01/01/2020','estado':'1','valmatricula':'20','valcuota':'100'}
  admin.post('matricula.php',enrollment);mid=query('SELECT id FROM matricula LIMIT 1');check('create matricula',mid.isdigit())
  enrollment.pop('nuevo');enrollment.update(guardar='1',codigo=mid,valcuota='200');admin.post('matricula.php',enrollment);check('update matricula',query('SELECT valor_cuota FROM matricula WHERE id='+mid)=='200.00')
  check('SQLi identifier rejected',admin.post('curso.php',{'excluir':'1','codigo':'1 OR 1=1'})[0]==422)
  png=subprocess.check_output(['php','-r','$i=imagecreatetruecolor(2,2);imagepng($i);'])
  check('upload CSRF rejected',admin.upload('test.png',png,False)[0]==403)
  check('upload PHP rejected',admin.upload('evil.php',b'<?php system("id");')[0]==422)
  check('upload traversal rejected',admin.upload('test.png',png,path='subir_imagen.php?carpeta=../../server')[0]==422)
  code,body,_=admin.upload('evil.php.png',png);match=re.search(rb'[a-f0-9]{32}\.jpg',body);check('valid image reencoded with random jpg name',code==200 and bool(match))
  if match:
   photo=match[0].decode();created_uploads.append(ROOT/'uploads'/photo);check('stored image only JPEG', (ROOT/'uploads'/photo).read_bytes().startswith(b'\xff\xd8'))
  query("UPDATE alumnos SET foto='"+photo+"' WHERE id="+aid)
  imagepath='imagen.php?name='+photo
  code,body,headers=admin.req(imagepath)
  check('admin image JPEG and security headers',code==200 and body==(ROOT/'uploads'/photo).read_bytes() and headers.get('Content-Type')=='image/jpeg' and headers.get('X-Content-Type-Options')=='nosniff' and 'no-store' in headers.get('Cache-Control',''))
  check('image traversal rejected',admin.req('imagen.php?name=..%2Fserver%2Fbootstrap.php')[0]==422)
  check('image missing returns 404',admin.req('imagen.php?name='+'0'*32+'.jpg')[0]==404)
  anon=Client(url)
  class NoRedirect(urllib.request.HTTPRedirectHandler):
   def redirect_request(self,*args,**kwargs):return None
  try:
   urllib.request.build_opener(NoRedirect).open(url+imagepath)
   anon_redirect=False
  except urllib.error.HTTPError as exc:anon_redirect=exc.code==303 and exc.headers.get('Location')=='login.php'
  check('anonymous image redirects to login',anon_redirect)
  code,body,_=admin.req('pdf.php?id='+mid);check('admin PDF PHP8.3',code==200 and body.startswith(b'%PDF-'))
  pupil=Client(url);pupil.req('login-alumno.php');code,body,_=pupil.post('login-alumno.php',{'usuario':'TEST001','contrasena':passwd});check('alumno login',code==200 and b'Bienvenido' in body)
  for page in ['alumno.php','curso.php','grupo.php','matricula.php','configuraciones.php','asistencia.php','subir_imagen.php']:
   check('alumno denied '+page,pupil.req(page)[0]==403)
  check('alumno own PDF',pupil.req('pdf.php?id='+mid)[1].startswith(b'%PDF-'))
  query("INSERT INTO alumnos(nombre,apellido,cedula,password) VALUES('Otro','Prueba','TEST002','"+hashed+"');")
  otherid=query("SELECT id FROM alumnos WHERE cedula='TEST002'");query(f"INSERT INTO matricula(id_alumnos,grupo_id,fecha_inicio) VALUES ({otherid},{gid},'2020-01-01');")
  code,body,headers=pupil.req(imagepath);check('alumno own image JPEG',code==200 and body.startswith(b'\xff\xd8') and headers.get('Content-Type')=='image/jpeg')
  outsider=Client(url);outsider.req('login-alumno.php');outsider.post('login-alumno.php',{'usuario':'TEST002','contrasena':passwd})
  check('other alumno image denied',outsider.req(imagepath)[0]==403)
  othermid=query('SELECT MAX(id) FROM matricula');check('alumno cannot read other PDF',pupil.req('pdf.php?id='+othermid)[0]==403)
  hid=query('SELECT id FROM horarios LIMIT 1')
  check('presence forged enrollment rejected',pupil.post('presencia.php',{'presencia':'1','txthorario':hid,'txtidmatricula':othermid,'txtidgrupo':gid,'txtdia':day})[0]==403)
  presence={'presencia':'1','txthorario':hid,'txtidmatricula':mid,'txtidgrupo':gid,'txtdia':day}
  check('presence CSRF rejected',pupil.req('presencia.php',presence)[0]==403)
  code,body,_=pupil.post('presencia.php',presence);check('attendance recorded',code==200 and query('SELECT COUNT(*) FROM asistencias')=='1')
  check('duplicate attendance rejected',pupil.post('presencia.php',presence)[0]==409)
  check('admin attendance report',admin.post('asistencia.php?id='+gid,{'fecha_inicio':'01/01/2020','fecha_fin':'01/01/2020'})[0]==200)
  query('UPDATE alumnos SET activo=0 WHERE id='+aid);check('disabled session denied',pupil.req('presencia.php')[0]==403);query('UPDATE alumnos SET activo=1 WHERE id='+aid)
  # delete in dependency order; history deliberately protected until test-only cleanup
  query('DELETE FROM asistencias;')
  for entity,ident in [('matricula',othermid),('matricula',mid),('grupo',gid),('curso',cid),('alumno',aid),('alumno',otherid)]:
   data={'codigo':ident,**({'accion':'excluir'} if entity=='alumno' else {'excluir':'1'})};admin.post(entity+'.php',data)
   table={'alumno':'alumnos','curso':'cursos','grupo':'grupos'}.get(entity,entity)
   check('delete '+entity+' '+ident,query('SELECT COUNT(*) FROM '+table+' WHERE id='+ident)=='0')
  code,body,_=admin.post('salir.php',{});check('logout clears authorization',code==200 and b'Ingrese su Usuario' in body)
  log.flush()
  check('PHP log free of Warning/Deprecated/Fatal',not re.search(r'\bPHP\s+(?:Warning|Deprecated|Fatal(?: error)?)\b',(runtime/'php.log').read_text()))
  print('ALL INTEGRATION CHECKS PASSED')
 finally:
  for p in reversed(procs):
   p.terminate()
   try:p.wait(timeout=15)
   except subprocess.TimeoutExpired:p.kill();p.wait()
  for f in files:f.close()
  if env_replaced:
   (ROOT/'.env').unlink(missing_ok=True)
   if (runtime/'original.env').exists(): (runtime/'original.env').rename(ROOT/'.env')
  if (runtime/'php.log').exists():shutil.copy(runtime/'php.log',ROOT/'tests/integration-http.log')
  (ROOT/'tests/integration-results.json').write_text(json.dumps(results,indent=2))
  for p in created_uploads:p.unlink(missing_ok=True)
  shutil.rmtree(runtime)
if __name__=='__main__':main()

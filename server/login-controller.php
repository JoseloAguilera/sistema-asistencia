<?php
require_once __DIR__.'/bootstrap.php';
csrf_check();
if ($_SERVER['REQUEST_METHOD']==='POST') {
 $username=is_string($_POST['usuario']??null)?trim($_POST['usuario']):'';
 $pass=is_string($_POST['contrasena']??null)?$_POST['contrasena']:'';
 // Shared database throttle, not reset by clearing browser cookies. No usernames/passwords logged.
 $key=hash('sha256',($_SERVER['REMOTE_ADDR']??'').'|'.mb_strtolower($username));
 $attempt=q('SELECT intentos, ultimo FROM login_intentos WHERE clave=?',[$key])->fetch();
 if ($attempt && (int)$attempt['intentos']>=10 && strtotime($attempt['ultimo'])>time()-900) fail(429,'Demasiados intentos. Espere 15 minutos.');
 $user=$role==='admin' ? q('SELECT * FROM usuarios WHERE usuario=? AND activo=1',[$username])->fetch() : q('SELECT * FROM alumnos WHERE cedula=? AND activo=1',[$username])->fetch();
 $hash=$user['password']??'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi';
 if ($user && password_verify($pass,$hash)) {
  q('DELETE FROM login_intentos WHERE clave=?',[$key]);
  session_regenerate_id(true);
  $_SESSION=['id'=>(int)$user['id'],'tipo_login'=>$role,'logueado'=>true,'nome_usuario'=>$role==='admin'?$user['usuario']:$user['nombre'],'nome_compl'=>$user['nombre'],'csrf'=>bin2hex(random_bytes(32))];
  if (password_needs_rehash($hash,PASSWORD_DEFAULT)) {
   if ($role==='admin') q('UPDATE usuarios SET password=? WHERE id=?',[password_hash($pass,PASSWORD_DEFAULT),$user['id']]);
   else q('UPDATE alumnos SET password=? WHERE id=?',[password_hash($pass,PASSWORD_DEFAULT),$user['id']]);
  }
  redirect($role==='admin'?'index.php':'presencia.php');
 }
 // Execute verify on missing accounts too, reducing username timing differences.
 if (!$user) password_verify($pass,$hash);
 q('INSERT INTO login_intentos(clave,intentos,ultimo) VALUES (?,1,NOW()) ON DUPLICATE KEY UPDATE intentos=IF(ultimo < NOW()-INTERVAL 15 MINUTE,1,intentos+1),ultimo=NOW()',[$key]);
 http_response_code(401); $mensaje='<p class="alert alert-danger">Los datos ingresados son incorrectos.</p>';
}

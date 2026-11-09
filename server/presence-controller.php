<?php
require_once __DIR__.'/bootstrap.php'; auth('alumno'); $connection=db();
$idalumno=$_SESSION['id'];
function getCurso($idcurso) { return q('SELECT * FROM cursos WHERE id=?',[$idcurso])->fetch(); }
$days=['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
date_default_timezone_set(getenv('APP_TIMEZONE')?:'America/Asuncion');
if ($_SERVER['REQUEST_METHOD']==='POST') {
 $schedule=q('SELECT h.*,m.id AS mid,m.grupo_id FROM horarios h JOIN grupos g ON g.id=h.grupos_id JOIN cursos c ON c.id=g.cursos_id JOIN matricula m ON m.grupo_id=g.id WHERE h.id=? AND m.id=? AND m.id_alumnos=? AND m.activo=1 AND g.activo=1 AND c.activo=1 AND m.fecha_inicio<=CURRENT_DATE()', [positive($_POST['txthorario']??''),positive($_POST['txtidmatricula']??''),$idalumno])->fetch();
 if (!$schedule) fail(403,'Matrícula u horario no autorizado');
 $today=$days[(int)date('w')];
 $normalize=fn($s)=>str_replace(['Miércoles','Sábado'],['Miercoles','Sabado'],$s);
 if ($normalize($schedule['dia'])!==$normalize($today) || date('H:i:s')<$schedule['hora_inicio'] || date('H:i:s')>$schedule['hora_fin']) fail(422,'Fuera del día u horario de clase');
 try {
  q('INSERT INTO asistencias(matricula_id,matricula_id_alumnos,matricula_grupo_id,horarios_id,dia,horario,fecha_add) VALUES (?,?,?,?,?,NOW(),NOW())',[$schedule['mid'],$idalumno,$schedule['grupo_id'],$schedule['id'],$today]);
  $mensaje='<div class="alert alert-success">PRESENCIA REGISTRADA CORRECTAMENTE</div>';
 } catch (PDOException $ex) { if ($ex->getCode()!=='23000') throw $ex; http_response_code(409); $mensaje='<div class="alert alert-warning">Ya registró presencia hoy.</div>'; }
}
$matriculas=q('SELECT m.* FROM matricula m JOIN grupos g ON g.id=m.grupo_id JOIN cursos c ON c.id=g.cursos_id WHERE m.id_alumnos=? AND m.activo=1 AND g.activo=1 AND c.activo=1',[$idalumno])->fetchAll();

<?php
require_once __DIR__.'/bootstrap.php'; auth('admin'); $connection=db();
if ($_SERVER['REQUEST_METHOD']==='POST') {
 $id=isset($_POST['nuevo'])?null:positive($_POST['codigo']??'');
 $connection->beginTransaction();
 try {
  if (isset($_POST['excluir'])) {
   q('DELETE FROM grupos WHERE id=?',[$id]);
  } else {
   $course=positive($_POST['curso']??''); $description=trim($_POST['descripcion']??'');
   $days=$_POST['dia']??[]; $start=$_POST['entrada']??''; $end=$_POST['salida']??'';
   if (!$description || !is_array($days) || !$days || count($days)>7) fail(422,'Descripción y días requeridos');
   if (!preg_match('/\A(?:[01]\d|2[0-3]):[0-5]\d\z/D',$start) || !preg_match('/\A(?:[01]\d|2[0-3]):[0-5]\d\z/D',$end) || $start>=$end) fail(422,'Horario inválido');
   foreach ($days as $day) if (!in_array($day,['Domingo','Lunes','Martes','Miercoles','Miércoles','Jueves','Viernes','Sabado','Sábado'],true)) fail(422,'Día inválido');
   $active=($_POST['estado']??'')==='1'?1:0;
   if ($id) q('UPDATE grupos SET descripcion=?,cursos_id=?,activo=? WHERE id=?',[$description,$course,$active,$id]);
   else {q('INSERT INTO grupos(descripcion,cursos_id,activo) VALUES (?,?,?)',[$description,$course,$active]);$id=(int)$connection->lastInsertId();}
   // Do not remove slots already referenced by attendance: preserve audit history.
   $existing=q('SELECT * FROM horarios WHERE grupos_id=?',[$id])->fetchAll();
   foreach ($existing as $slot) {
    if (!in_array($slot['dia'],$days,true)) q('DELETE FROM horarios WHERE id=?',[$slot['id']]);
   }
   foreach (array_unique($days) as $day) {
    q('INSERT INTO horarios(hora_inicio,hora_fin,dia,grupos_id,grupos_cursos_id) VALUES (?,?,?,?,?) ON DUPLICATE KEY UPDATE hora_inicio=VALUES(hora_inicio),hora_fin=VALUES(hora_fin),grupos_cursos_id=VALUES(grupos_cursos_id)',[$start,$end,$day,$id,$course]);
   }
  }
  $connection->commit();$tipomensaje='success';$mensaje='<h3>Perfecto!</h3><p>Datos guardados correctamente.</p>';
 } catch (PDOException $ex) { $connection->rollBack(); http_response_code(409);$tipomensaje='error';$mensaje='<p>Operación rechazada: existen datos relacionados o valores duplicados.</p>'; }
}

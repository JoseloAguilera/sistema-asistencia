<?php
require_once __DIR__.'/server/bootstrap.php';
auth('admin');
$input=$_GET['input']??'foto'; $evento=$_GET['evento']??'add';
if ($input!=='foto' || !in_array($evento,['add','alt'],true)) fail(422,'Destino inválido');
if (isset($_GET['carpeta']) && $_GET['carpeta']!=='img_alumnos') fail(422,'Destino inválido');
if ($_SERVER['REQUEST_METHOD']==='POST') {
 $file=$_FILES['userfile']??[];
 if (($file['error']??UPLOAD_ERR_NO_FILE)!==UPLOAD_ERR_OK || ($file['size']??0)>2*1024*1024 || !is_uploaded_file($file['tmp_name']??'')) fail(422,'Imagen inválida (máximo 2 MB)');
 $info=@getimagesize($file['tmp_name']);
 $mime=(new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
 if (!$info || !in_array($mime,['image/jpeg','image/png','image/webp'],true) || $info[0]>4096 || $info[1]>4096 || $info[0]*$info[1]>12000000) fail(422,'Formato o dimensiones inválidas');
 $image=@imagecreatefromstring(file_get_contents($file['tmp_name']));
 if (!$image) fail(422,'No se pudo decodificar la imagen');
 $name=bin2hex(random_bytes(16)).'.jpg';
 $dir=__DIR__.'/uploads'; if (!is_dir($dir)) mkdir($dir,0750,true);
 if (!imagejpeg($image,$dir.'/'.$name,90)) fail(500,'No se pudo guardar');
 imagedestroy($image); chmod($dir.'/'.$name,0640);
 header('Content-Type: text/html; charset=utf-8');
 // Only fixed DOM properties; uploaded bytes, paths and query values never enter JS.
 $form=$evento==='add'?'form1':'form';
 echo '<script>if(window.opener){window.opener.document.forms['.json_encode($form).'].elements.foto.value='.json_encode($name).';window.close();}</script>';exit;
}
?><!DOCTYPE html><html lang="es"><head><meta charset="utf-8"><title>Subir imagen</title></head><body>
<form method="post" enctype="multipart/form-data"><?php echo csrf_field(); ?><input type="file" name="userfile" accept="image/jpeg,image/png,image/webp" required><button>Subir Imagen</button></form></body></html>

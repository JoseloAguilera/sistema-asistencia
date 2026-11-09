<?php
require_once __DIR__.'/server/bootstrap.php';
auth();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 $_SESSION=[];
 $p=session_get_cookie_params(); setcookie(session_name(),'', ['expires'=>time()-3600,'path'=>$p['path'],'secure'=>$p['secure'],'httponly'=>true,'samesite'=>'Lax']);
 session_destroy(); redirect('login.php');
}
?><!DOCTYPE html><html lang="es"><head><meta charset="utf-8"><title>Salir</title></head><body><form method="post"><?php echo csrf_field(); ?><button>Confirmar salida</button></form></body></html>

<?php
require_once __DIR__.'/server/bootstrap.php';
auth();
$name = $_GET['name'] ?? '';
if (!is_string($name) || !preg_match('/\A[a-f0-9]{32}\.jpg\z/D', $name)) fail(422, 'Imagen inválida');
$directory = realpath(__DIR__.'/uploads');
$path = $directory === false ? false : realpath($directory.'/'.$name);
if ($path === false || dirname($path) !== $directory || is_link($directory.'/'.$name) || !is_file($path)) fail(404, 'Imagen no encontrada');
if ($_SESSION['tipo_login'] !== 'admin' && !q('SELECT id FROM alumnos WHERE id=? AND foto=?', [$_SESSION['id'], $name])->fetchColumn()) fail(403, 'No autorizado');
$handle = @fopen($path, 'rb');
if ($handle === false) fail(404, 'Imagen no encontrada');
header('Content-Type: image/jpeg');
header('X-Content-Type-Options: nosniff');
header('Cache-Control: no-store');
fpassthru($handle);
fclose($handle);

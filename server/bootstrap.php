<?php
declare(strict_types=1);
ini_set('display_errors', '0');
error_reporting(E_ALL);
if (PHP_SAPI !== 'cli') ob_start();
set_exception_handler(function(Throwable $e): void { error_log('Application error: '.get_class($e).' at '.basename($e->getFile()).':'.$e->getLine()); if (ob_get_level()) ob_clean(); http_response_code(500); exit('Error interno. Consulte al administrador.'); });
// Resolve from the application root, never from the caller's working directory.
require_once dirname(__DIR__).'/vendor/autoload.php';
try {
 Dotenv\Dotenv::createImmutable(dirname(__DIR__))->safeLoad();
} catch (Throwable $e) {
 // Parser exception messages can contain credentials: never log the exception.
 error_log('Application configuration error');
 http_response_code(500);
 exit('Error interno. Consulte al administrador.');
}
function app_env(string $key, array $config = [], string $default = ''): string {
 $process = getenv($key);
 return $process !== false ? $process : (string)($_ENV[$key] ?? $_SERVER[$key] ?? $config[$key] ?? $default);
}
function fail(int $code, string $message): never { http_response_code($code); exit($message); }
function redirect(string $to): never { header('Location: '.$to, true, 303); exit; }
function e(mixed $s): string { return htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
$https = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
if (PHP_SAPI !== 'cli') {
 header('X-Content-Type-Options: nosniff'); header('X-Frame-Options: SAMEORIGIN'); header('Referrer-Policy: same-origin'); header('Cache-Control: no-store');
 if ($https) header('Strict-Transport-Security: max-age=31536000');
 ini_set('session.use_strict_mode','1'); ini_set('session.use_only_cookies','1');
 session_set_cookie_params(['httponly'=>true,'secure'=>$https,'samesite'=>'Lax','path'=>'/']);
 session_start();
 $_SESSION['csrf'] ??= bin2hex(random_bytes(32));
}
function csrf_field(): string { return '<input type="hidden" name="csrf" value="'.e($_SESSION['csrf']).'">'; }
function csrf_check(): void {
 if ($_SERVER['REQUEST_METHOD'] === 'POST' && (!is_string($_POST['csrf'] ?? null) || !hash_equals($_SESSION['csrf'], $_POST['csrf']))) fail(403,'CSRF inválido');
}
function auth(?string $role = null): void {
 if (empty($_SESSION['id']) || empty($_SESSION['tipo_login'])) redirect('login.php');
 if ($role && $_SESSION['tipo_login'] !== $role) fail(403,'No autorizado');
 $table = $_SESSION['tipo_login'] === 'admin' ? 'usuarios' : 'alumnos';
 $q = db()->prepare("SELECT activo FROM $table WHERE id = ?"); $q->execute([$_SESSION['id']]);
 if ((int)$q->fetchColumn() !== 1) { $_SESSION=[]; session_destroy(); fail(403,'Cuenta inactiva'); }
 csrf_check();
}
function db(): PDO {
 static $pdo;
 if ($pdo) return $pdo;
 $config=[]; $path=app_env('APP_CONFIG') ?: dirname(__DIR__,2).'/asistencia-private.php';
 if (is_file($path)) $config=require $path;
 $get=fn($key,$default='') => app_env($key,$config,$default);
 $name=$get('DB_NAME'); $user=$get('DB_USER');
 if (!$name || !$user) throw new RuntimeException('DB configuration missing');
 $socket=$get('DB_SOCKET');
 $dsn= $socket ? 'mysql:unix_socket='.$socket : 'mysql:host='.$get('DB_HOST','localhost').';port='.$get('DB_PORT','3306');
 return $pdo=new PDO($dsn.';dbname='.$name.';charset=utf8mb4',$user,$get('DB_PASS'),[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES=>false]);
}
function q(string $sql, array $params=[]): PDOStatement { $s=db()->prepare($sql); $s->execute($params); return $s; }
function positive(mixed $v): int { if (!is_scalar($v) || !ctype_digit((string)$v) || (int)$v<1) fail(422,'Identificador inválido'); return (int)$v; }
function password_new(string $pass): string { if (strlen($pass)<12 || strlen($pass)>72) fail(422,'Use una contraseña de 12 a 72 bytes'); return password_hash($pass,PASSWORD_DEFAULT); }
function photo_name(string $name): string { if ($name!=='' && (!preg_match('/\A[a-f0-9]{32}\.jpg\z/D',$name) || !is_file(__DIR__.'/../uploads/'.$name))) fail(422,'Imagen inválida'); return $name; }

function validate_input(): void {
 foreach (['codigo','curso','alumno','grupo','txthorario','txtidmatricula','txtidgrupo'] as $key) {
  if (isset($_POST[$key]) && $_POST[$key] !== '') positive($_POST[$key]);
 }
 if (isset($_GET['id'])) positive($_GET['id']);
 if (!in_array($_SERVER['REQUEST_METHOD']??'GET',['GET','POST','HEAD'],true)) fail(405,'Método no permitido');
}
if (PHP_SAPI !== 'cli') validate_input();

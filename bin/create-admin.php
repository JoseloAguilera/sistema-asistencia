<?php
declare(strict_types=1);
if (PHP_SAPI!=='cli') { http_response_code(404); exit; }
require_once __DIR__.'/../server/bootstrap.php';
if ($argc!==1 || !stream_isatty(STDIN)) { fwrite(STDERR,"Ejecute interactivamente: php bin/create-admin.php (sin argumentos).\n");exit(1); }
if ((int)q('SELECT COUNT(*) FROM usuarios')->fetchColumn()!==0) { fwrite(STDERR,"Ya existe un administrador. Use Configuraciones.\n");exit(1); }
function ask(string $label): string { fwrite(STDOUT,$label);$s=fgets(STDIN);if ($s===false) exit(1);return trim($s); }
function secret(string $label): string {
 fwrite(STDOUT,$label);$state=shell_exec('stty -g');
 if (!$state) throw new RuntimeException('No se puede ocultar entrada');
 try { shell_exec('stty -echo');$s=fgets(STDIN);if($s===false)throw new RuntimeException('Entrada terminada');return rtrim($s,"\r\n"); }
 finally { shell_exec('stty '.escapeshellarg(trim($state)));fwrite(STDOUT,"\n"); }
}
$login=ask('Usuario administrador: ');$name=ask('Nombre: ');$email=ask('Correo: ');
if (!preg_match('/\A[a-zA-Z0-9_.-]{3,100}\z/D',$login) || !$name || !filter_var($email,FILTER_VALIDATE_EMAIL)) { fwrite(STDERR,"Datos inválidos.\n");exit(1); }
$p=secret('Contraseña (12–72 bytes): ');$repeat=secret('Repita contraseña: ');
if (!hash_equals($p,$repeat)) { fwrite(STDERR,"No coinciden.\n");exit(1); }
$hash=password_new($p);unset($p,$repeat);
// Atomic named lock prevents two concurrent first-admin creations.
if ((int)q("SELECT GET_LOCK('asistencia_first_admin',10)")->fetchColumn()!==1) exit(1);
try {
 if ((int)q('SELECT COUNT(*) FROM usuarios')->fetchColumn()!==0) { fwrite(STDERR,"Ya existe administrador.\n");exit(1); }
 q('INSERT INTO usuarios(nombre,usuario,password,email,activo) VALUES (?,?,?,?,1)',[$name,$login,$hash,$email]);
 fwrite(STDOUT,"Administrador creado.\n");
} finally {q("SELECT RELEASE_LOCK('asistencia_first_admin')");}

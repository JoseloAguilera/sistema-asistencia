# Sistema de asistencia — Hostinger

Rama de despliegue: **master**. Incluye la versión corregida incorporada desde `hostinger`, con PHP 8.3 y dependencias de producción. `index.php` está en la raíz, lista para conectar con Git de hPanel. El historial anterior se conserva.

## Instalación

1. Crear el subdominio `asistencia.jbsolutionspy.com` en Hostinger y seleccionar su carpeta exclusiva y vacía como destino del despliegue Git.
2. Repositorio: `https://github.com/JoseloAguilera/sistema-asistencia.git`; rama: `master`.
3. DNS solicitado: registro **A**, nombre **asistencia**, destino **149.62.37.197**, TTL **300**, solo DNS durante la activación de SSL. La configuración DNS no implica que la app o MySQL estén instalados.
4. Usar PHP 8.3 con PDO MySQL, GD, mbstring y XML. `vendor/` está incluido.
5. Crear una base MySQL vacía y un usuario exclusivo desde hPanel. Seleccionar esa base en phpMyAdmin e importar [`database/install.sql`](database/install.sql) una sola vez. No ejecutar sobre bases existentes. El SQL crea tablas/vistas, no cuentas del hosting ni datos de prueba.
6. Copiar `.env.example` a `.env` junto a `index.php` y completar `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER` y **`DB_PASS`** solo en ese equipo/servidor. Usar valores distintos para local y Hostinger; nunca subir `.env` a Git. Se mantiene la alternativa de archivo privado fuera de todos los directorios públicos (ver guía).
7. Crear el primer administrador desde terminal interactiva, en la raíz del proyecto:

```sh
php bin/create-admin.php
```

No hay credenciales predeterminadas. No publicar un instalador web. Activar certificado HTTPS, redirección segura y zona horaria adecuada antes de admitir usuarios reales.

Guía completa: [`deployment/HOSTINGER-GITHUB.md`](deployment/HOSTINGER-GITHUB.md).

## Seguridad y actualizaciones

- `.env` se carga tanto en HTTP como en CLI. Prioridad: proceso > `.env` > archivo privado anterior. `.env.example` no contiene datos reales; `.env` está ignorado. **`.gitignore` no protege HTTP**: verificar `/.env` y variantes con respuesta 403/404 en Hostinger, incluso sin mod_rewrite. `php -S` no aplica `.htaccess` y no debe exponerse públicamente.
- Mantener `.htaccess` y `uploads/.htaccess`. Verificar en Hostinger que SQL, `.git`, `server/`, `vendor/`, `bin/` y `deployment/` no sean accesibles por HTTP.
- No versionar credenciales, fotos de alumnos, logs, backups ni datos reales. El historial anterior de Git NO queda eliminado por esta rama; rotar cualquier secreto histórico en su servicio original.
- Los uploads y la base de datos no se sincronizan con Git. Confirmar que el despliegue respete archivos no versionados antes de habilitar actualizaciones automáticas.
- Git no ejecuta SQL automáticamente. Cambios futuros de esquema requieren una migración específica y respaldo.
- Mantener los cambios de código en `master`; no reintroducir archivos históricos, dumps, fotos ni credenciales en el árbol de despliegue.

## Verificación

Las correcciones tienen pruebas locales HTTP con PHP 8.3 y MariaDB aislada: login, roles, CSRF, CRUD, matrículas, asistencia, PDF y uploads. La conectividad Git, reglas Apache/LiteSpeed, SSL, permisos y persistencia deben verificarse en el hosting real. Esta publicación del código no acredita por sí sola un despliegue funcional.

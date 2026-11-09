# Sistema de asistencia — Hostinger

Rama de despliegue: **hostinger**. Contiene la aplicación corregida para PHP 8.3 y las dependencias de producción. `index.php` está en la raíz, lista para conectar con Git de hPanel. La rama histórica `master` no se modifica y NO debe usarse para este despliegue.

## Instalación

1. Crear el subdominio `asistencia.jbsolutionspy.com` en Hostinger y seleccionar su carpeta exclusiva y vacía como destino del despliegue Git.
2. Repositorio: `https://github.com/JoseloAguilera/sistema-asistencia.git`; rama: `hostinger`.
3. DNS solicitado: registro **A**, nombre **asistencia**, destino **149.62.37.197**, TTL **300**, solo DNS durante la activación de SSL. La configuración DNS no implica que la app o MySQL estén instalados.
4. Usar PHP 8.3 con PDO MySQL, GD, mbstring y XML. `vendor/` está incluido.
5. Crear una base MySQL vacía y un usuario exclusivo desde hPanel. Seleccionar esa base en phpMyAdmin e importar [`database/install.sql`](database/install.sql) una sola vez. No ejecutar sobre bases existentes. El SQL crea tablas/vistas, no cuentas del hosting ni datos de prueba.
6. Copiar [`deployment/asistencia-private.example.php`](deployment/asistencia-private.example.php) a una ubicación privada fuera de TODOS los directorios públicos como `asistencia-private.php`. Completar credenciales solo en el servidor. Ver la guía para la ruta predeterminada y `APP_CONFIG` cuando el subdominio está bajo otra carpeta pública.
7. Crear el primer administrador desde terminal interactiva, en la raíz del proyecto:

```sh
php bin/create-admin.php
```

No hay credenciales predeterminadas. No publicar un instalador web. Activar certificado HTTPS, redirección segura y zona horaria adecuada antes de admitir usuarios reales.

Guía completa: [`deployment/HOSTINGER-GITHUB.md`](deployment/HOSTINGER-GITHUB.md).

## Seguridad y actualizaciones

- Mantener `.htaccess` y `uploads/.htaccess`. Verificar en Hostinger que SQL, `.git`, `server/`, `vendor/`, `bin/` y `deployment/` no sean accesibles por HTTP.
- No versionar credenciales, fotos de alumnos, logs, backups ni datos reales. El historial anterior de Git NO queda eliminado por esta rama; rotar cualquier secreto histórico en su servicio original.
- Los uploads y la base de datos no se sincronizan con Git. Confirmar que el despliegue respete archivos no versionados antes de habilitar actualizaciones automáticas.
- Git no ejecuta SQL automáticamente. Cambios futuros de esquema requieren una migración específica y respaldo.
- Mantener cambios de código en esta rama o generar una exportación limpia nueva; no mezclar directamente el árbol histórico completo de `master` sobre producción.

## Verificación

Las correcciones tienen pruebas locales HTTP con PHP 8.3 y MariaDB aislada: login, roles, CSRF, CRUD, matrículas, asistencia, PDF y uploads. La conectividad Git, reglas Apache/LiteSpeed, SSL, permisos y persistencia deben verificarse en el hosting real. Esta publicación del código no acredita por sí sola un despliegue funcional.

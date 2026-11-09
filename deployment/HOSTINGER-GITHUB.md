# Publicar asistencia.jbsolutionspy.com con GitHub y Hostinger

## Estado / requisito previo

Esta es la rama de despliegue `hostinger`: contiene código corregido y una exportación limpia, sin fotos históricas, secretos, pruebas ni backups. Conectar ESTA rama en hPanel; no desplegar la rama histórica `master`. La publicación en GitHub no implica instalación de MySQL ni despliegue funcional en Hostinger.

El código web y `index.php` están en la raíz de la rama; el SQL está en `database/install.sql` y los ejemplos/documentación en `deployment/`, protegidos por el .htaccess incluido. No hace falta extraer un ZIP ni ejecutar un build en Hostinger. La configuración REAL no se versiona. Importar SQL y crear el administrador son pasos separados del despliegue Git.

Las instrucciones de panel son orientativas: nombres y capacidades pueden variar según el plan y versión de hPanel. La documentación oficial no pudo consultarse desde este servidor (HTTP 403). Si no aparece Git, SSH, webhook o una opción de directorio, comprobar disponibilidad con Hostinger; no asumir que todos los planes la incluyen.

## 1. Crear alojamiento para el subdominio

1. Abrir el sitio/plan correcto en hPanel, buscar la gestión de subdominios y crear `asistencia.jbsolutionspy.com`.
2. Registrar la carpeta que hPanel asigna como raíz del subdominio. Debe ser exclusiva de esta aplicación; NO desplegar sobre la web principal.
3. Mantener esa carpeta VACÍA antes del primer clon Git. Si contiene archivos, respaldarlos antes y revisar qué son; no borrarlos a ciegas.
4. Buscar en los detalles del alojamiento la IP del servidor. No usar una IP adivinada ni la del servidor donde trabaja el asistente.

## 2. Apuntar DNS sin mover el dominio principal

En el proveedor DNS autoritativo de `jbsolutionspy.com` (Cloudflare si sigue administrando la zona), crear:

- Tipo: A
- Nombre: asistencia
- Destino: 149.62.37.197 (IP indicada por José en la captura de Hostinger)
- TTL: 300 segundos
- Proxy Cloudflare: solo DNS durante la instalación/validación de SSL

No cambiar nameservers, MX, correo, dominio raíz ni otros subdominios. Si ya existe un A/AAAA/CNAME para asistencia, inspeccionarlo y respaldarlo antes de sustituirlo. No mantener un AAAA de otro servidor junto al nuevo A. Cuando DNS resuelva correctamente, activar SSL en Hostinger y forzar HTTPS. Si después se habilita el proxy Cloudflare, usar Full (strict) con certificado válido en origen, no Flexible.

## 3. Conectar GitHub con Hostinger

1. Confirmar que la rama limpia y corregida ya fue subida a GitHub. No seleccionar main si todavía contiene la versión antigua.
2. En el sitio correcto de hPanel, buscar Git/GIT e introducir el repositorio `https://github.com/JoseloAguilera/sistema-asistencia` y la rama aprobada.
3. Elegir como directorio de despliegue EXACTAMENTE la raíz del subdominio anotada en el paso 1. La interpretación de la ruta puede ser relativa al sitio: comprobarlo en el panel. Si Git no permite apuntar ahí, detenerse; no desplegar sobre la web principal ni asumir que se puede cambiar el document root.
4. Si el repositorio es privado, usar la conexión SSH/deploy key de solo lectura admitida por Hostinger y añadir únicamente la CLAVE PÚBLICA en GitHub > repositorio > Settings > Deploy keys. No introducir tokens en la URL del repo ni publicar claves privadas. Seguir la URL SSH que indique el proveedor.
5. Hacer el primer despliegue manual y comprobar qué carpeta recibió index.php.
6. Si hPanel ofrece despliegue automático, copiar SU URL de webhook y configurarla en GitHub > Settings > Webhooks para eventos push conforme a las instrucciones que muestre el panel. Tratar esa URL como sensible y no guardarla en el repositorio. No inventar endpoint, secreto o Content-Type: usar lo que indique Hostinger.
7. Probar un cambio inocuo aprobado y observar tanto la entrega del webhook como el contenido actualizado en el dominio. Conectar el repositorio no demuestra por sí solo sincronización automática.

Git despliega ARCHIVOS. No crea bases, no ejecuta install.sql automáticamente y no sincroniza registros de alumnos. Los uploads y la configuración privada deben sobrevivir a actualizaciones; confirmar que el método elegido no elimina archivos no versionados antes de activarlo.

## 4. Crear base MySQL e importar esquema

1. En hPanel, crear una base MySQL VACÍA y un usuario exclusivo con acceso solo a esa base. Guardar los nombres completos con prefijo que asigne Hostinger.
2. Abrir phpMyAdmin y seleccionar esa base.
3. En Importar, cargar `database/install.sql` desde la rama Git `hostinger` desplegada; no se utiliza un ZIP ni la ruta `private/install.sql`.
4. Ejecutar una sola vez sobre base vacía. El archivo crea las tablas y vistas; NO crea el contenedor de base ni el usuario de Hostinger porque eso se gestiona en hPanel.
5. No importar el SQL histórico `ssdpy-assist.sql`. No repetir la instalación sobre datos existentes ni agregar DROP TABLE para resolver errores. Una actualización futura necesitará su migración revisada.

El esquema no contiene contraseñas, administradores de prueba ni datos de alumnos. Requiere soporte de columnas generadas y vistas, probado localmente con MariaDB; comprobar versión/permisos del hosting.

## 5. Conectar la app a MySQL

Copiar `deployment/asistencia-private.example.php` FUERA de la raíz web y renombrarlo `asistencia-private.php`. Completar DB_HOST, DB_PORT, DB_NAME, DB_USER y DB_PASS exclusivamente en el servidor. No subir esa copia real a GitHub.

Ruta que busca la app por defecto: un nivel por encima de la raíz web. Ejemplos:

- Raíz `/ruta/sitio/public_html` -> config `/ruta/sitio/asistencia-private.php`.
- Raíz `/ruta/public_html/asistencia` -> config `/ruta/public_html/asistencia-private.php`. En este segundo caso el padre pertenece a otra web y no es un lugar privado seguro: usar ubicación realmente fuera de todos los document roots y definir APP_CONFIG en el entorno PHP del hosting. Si no se puede configurar, revisar la disposición de directorios ANTES de publicar.

Para este proyecto, el entorno PHP puede usar APP_CONFIG para la ruta absoluta de un archivo privado. No se debe asumir que subir un .env configura variables: esta app NO carga dotenv automáticamente.

Seleccionar PHP 8.3 con PDO MySQL, GD, mbstring y XML. Las dependencias van incluidas en la rama de despliegue limpia; no es necesario ejecutar Composer en cada visita.

## 6. Crear el primer administrador

Desde SSH/terminal interactiva, entrar en la raíz de la aplicación y ejecutar:

```sh
php bin/create-admin.php
```

Pide los datos y la contraseña de forma interactiva. No poner contraseñas en comandos, GitHub o chat. No hay credenciales predeterminadas. Si el plan no tiene terminal compatible, coordinar un método privado con el proveedor; no publicar un instalador abierto en la web.

## 7. Verificar antes de admitir usuarios

- HTTPS válido y redirección desde HTTP; cookies Secure, HttpOnly y SameSite.
- Login admin/alumno y acceso por roles; matrícula, asistencias, PDF y fotos.
- `/database/install.sql`, `/server/bootstrap.php`, `/vendor/autoload.php`, `/bin/create-admin.php`, `/.git/config` y `/composer.lock` devuelven 403/404 sin contenido privado.
- Mantener .htaccess principal y uploads/.htaccess; sin listados de directorio ni ejecución de PHP en uploads.
- Config privada inaccesible desde CUALQUIER web del alojamiento.
- Backup privado de BD y uploads; actualización Git sin perderlos.
- Confirmar zona horaria PHP/BD antes de marcar asistencias.

Pruebas locales no verifican reglas Apache/LiteSpeed, SSL, permisos reales ni webhook. Esos puntos se prueban en Hostinger.

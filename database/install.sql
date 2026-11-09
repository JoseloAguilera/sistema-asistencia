-- Instalación NUEVA: seleccionar previamente la base vacía de Hostinger.
-- No contiene usuarios, credenciales ni datos de alumnos. No ejecutar sobre una BD existente.
SET NAMES utf8mb4;
CREATE TABLE usuarios (
 id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
 nombre VARCHAR(150) NOT NULL, usuario VARCHAR(100) NOT NULL UNIQUE,
 password VARCHAR(255) NOT NULL, email VARCHAR(254) NOT NULL DEFAULT '',
 activo TINYINT NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE alumnos (
 id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
 nombre VARCHAR(150) NOT NULL, apellido VARCHAR(150) NOT NULL, cedula VARCHAR(45) NOT NULL UNIQUE,
 telefono_alumno VARCHAR(45) NOT NULL DEFAULT '', fecha_nac VARCHAR(45) NOT NULL DEFAULT '',
 email VARCHAR(254) NOT NULL DEFAULT '', ruc VARCHAR(45) NOT NULL DEFAULT '',
 razon_social VARCHAR(150) NOT NULL DEFAULT '', ciudad VARCHAR(150) NOT NULL DEFAULT '', direccion VARCHAR(255) NOT NULL DEFAULT '',
 nombre_ref VARCHAR(150) NOT NULL DEFAULT '', telefono_ref VARCHAR(45) NOT NULL DEFAULT '',
 mama VARCHAR(150) NOT NULL DEFAULT '', papa VARCHAR(150) NOT NULL DEFAULT '',
 telefono_mama VARCHAR(45) NOT NULL DEFAULT '', telefono_papa VARCHAR(45) NOT NULL DEFAULT '',
 estado VARCHAR(45) NOT NULL DEFAULT 'activo', activo TINYINT NOT NULL DEFAULT 1,
 password VARCHAR(255) NOT NULL, foto VARCHAR(80) NOT NULL DEFAULT '',
 fecha_add DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, fecha_update DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE cursos (
 id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
 nombre VARCHAR(150) NOT NULL, desc_corta TEXT, desc_detallada TEXT,
 duracion_meses INT NOT NULL, activo TINYINT NOT NULL DEFAULT 1,
 valor_cuota DECIMAL(12,2) NOT NULL DEFAULT 0, `valor_matrícula` DECIMAL(12,2) NOT NULL DEFAULT 0,
 fecha_add DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, fecha_update DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE grupos (
 id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
 descripcion VARCHAR(150) NOT NULL, cursos_id INT NOT NULL, activo TINYINT NOT NULL DEFAULT 1,
 FOREIGN KEY(cursos_id) REFERENCES cursos(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE horarios (
 id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
 hora_inicio TIME NOT NULL, hora_fin TIME NOT NULL, dia VARCHAR(15) NOT NULL,
 grupos_id INT NOT NULL, grupos_cursos_id INT NOT NULL,
 UNIQUE KEY grupo_dia(grupos_id,dia),
 FOREIGN KEY(grupos_id) REFERENCES grupos(id) ON DELETE CASCADE,
 FOREIGN KEY(grupos_cursos_id) REFERENCES cursos(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE matricula (
 id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, id_alumnos INT NOT NULL, grupo_id INT NOT NULL,
 fecha_inicio DATE NOT NULL, valor_cuota DECIMAL(12,2) NOT NULL DEFAULT 0, valor_matricula DECIMAL(12,2) NOT NULL DEFAULT 0,
 activo TINYINT NOT NULL DEFAULT 1, fecha_add DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, fecha_update DATETIME NULL,
 UNIQUE KEY alumno_grupo(id_alumnos,grupo_id),
 FOREIGN KEY(id_alumnos) REFERENCES alumnos(id), FOREIGN KEY(grupo_id) REFERENCES grupos(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE asistencias (
 id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
 matricula_id INT NOT NULL, matricula_id_alumnos INT NOT NULL, matricula_grupo_id INT NOT NULL,
 horarios_id INT NOT NULL, dia VARCHAR(15) NOT NULL, horario DATETIME NOT NULL,
 fecha_add DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
 fecha DATE GENERATED ALWAYS AS (DATE(horario)) STORED,
 UNIQUE KEY asistencia_diaria(matricula_id,horarios_id,fecha),
 FOREIGN KEY(matricula_id) REFERENCES matricula(id),
 FOREIGN KEY(matricula_id_alumnos) REFERENCES alumnos(id),
 FOREIGN KEY(matricula_grupo_id) REFERENCES grupos(id),
 FOREIGN KEY(horarios_id) REFERENCES horarios(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE login_intentos (
 clave CHAR(64) NOT NULL PRIMARY KEY, intentos INT NOT NULL, ultimo DATETIME NOT NULL,
 INDEX(ultimo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE VIEW vista_alumnos AS
 SELECT m.id AS idmatricula,m.id_alumnos AS idalumno,m.grupo_id AS idgrupo,m.fecha_inicio,
 a.nombre AS nombrealumno,a.apellido AS apellidoalumno
 FROM matricula m JOIN alumnos a ON a.id=m.id_alumnos WHERE m.activo=1;
CREATE VIEW informe_presencia AS
 SELECT s.id,s.matricula_id_alumnos AS idalumno,s.matricula_grupo_id AS idgrupo,
 a.nombre AS nombrealumno,a.apellido AS apellidoalumno,s.dia AS diamarcado,
 DATE(s.horario) AS fecha_marcacion,TIME(s.horario) AS hora_de_marcacion,'PRESENTE' AS asistencia
 FROM asistencias s JOIN alumnos a ON a.id=s.matricula_id_alumnos;

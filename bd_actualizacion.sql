-- ============================================================
--  Actualización de base de datos - Chamba Ya
--  Aplicar sobre la base `bd_chamba_ya` ya existente.
--  Es idempotente: se puede correr más de una vez sin romper.
-- ============================================================

USE bd_chamba_ya;

-- 1) Columnas de preferencias en la tabla usuario
ALTER TABLE usuario
  ADD COLUMN IF NOT EXISTS notif_ofertas TINYINT(1)  NOT NULL DEFAULT 1,
  ADD COLUMN IF NOT EXISTS notif_vistas  TINYINT(1)  NOT NULL DEFAULT 1,
  ADD COLUMN IF NOT EXISTS notif_boletin TINYINT(1)  NOT NULL DEFAULT 0,
  ADD COLUMN IF NOT EXISTS visibilidad   VARCHAR(20) NOT NULL DEFAULT 'publico';

-- 2) Tabla de reportes
CREATE TABLE IF NOT EXISTS reporte (
  idReporte           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  idUsuarioReporta    INT UNSIGNED NOT NULL,
  idAnuncio           INT UNSIGNED NULL,
  idUsuarioReportado  INT UNSIGNED NULL,
  motivo              VARCHAR(50)  NOT NULL,
  detalle             TEXT         NULL,
  fecha               DATETIME     DEFAULT CURRENT_TIMESTAMP,
  estado              ENUM('Pendiente','Revisado','Descartado') DEFAULT 'Pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3) Tabla de notificaciones
CREATE TABLE IF NOT EXISTS notificacion (
  idNotificacion INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  idUsuario      INT UNSIGNED NOT NULL,
  mensaje        VARCHAR(255) NOT NULL,
  link           VARCHAR(255) NULL,
  leida          TINYINT(1)   NOT NULL DEFAULT 0,
  fecha          DATETIME     DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_usuario_leida (idUsuario, leida)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4) Habilidades base (solo se insertan si la tabla está vacía)
INSERT INTO habilidad (nombre, categoria)
SELECT * FROM (
  SELECT 'Puntualidad'              AS nombre, 'General' AS categoria UNION ALL
  SELECT 'Responsabilidad',          'General' UNION ALL
  SELECT 'Honestidad',               'General' UNION ALL
  SELECT 'Trabajo en equipo',        'General' UNION ALL
  SELECT 'Atencion al detalle',      'General' UNION ALL
  SELECT 'Rapidez',                  'General' UNION ALL
  SELECT 'Experiencia comprobable',  'General' UNION ALL
  SELECT 'Herramientas propias',     'General' UNION ALL
  SELECT 'Disponibilidad inmediata', 'General' UNION ALL
  SELECT 'Buen trato al cliente',    'General' UNION ALL
  SELECT 'Limpieza en el trabajo',   'General' UNION ALL
  SELECT 'Garantia del trabajo',     'General'
) AS nuevas
WHERE NOT EXISTS (SELECT 1 FROM habilidad);

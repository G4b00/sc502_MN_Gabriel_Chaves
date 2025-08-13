CREATE DATABASE IF NOT EXISTS `EncuestaApp`;

USE `EncuestaApp`;
--
-- Estructura de la tabla `usuarios`
--
CREATE TABLE `usuarios` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4;

--
-- Estructura de la tabla `encuestas`
--
CREATE TABLE `encuestas` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `id_creador` INT(11) NOT NULL,
  `titulo` VARCHAR(255) NOT NULL,
  `descripcion` TEXT,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id_creador`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4;

--
-- Estructura de la tabla `preguntas`
--
CREATE TABLE `preguntas` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `id_encuesta` INT(11) NOT NULL,
  `texto_pregunta` TEXT NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id_encuesta`) REFERENCES `encuestas`(`id`) ON DELETE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4;

--
-- Estructura de la tabla `respuestas`
--
CREATE TABLE `respuestas` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `id_pregunta` INT(11) NOT NULL,
  `id_usuario` INT(11) NOT NULL,
  `valor_respuesta` INT(1) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id_pregunta`) REFERENCES `preguntas`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`id_usuario`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE,
  UNIQUE (`id_pregunta`, `id_usuario`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `participantes` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `id_encuesta` INT(11) NOT NULL,
  `id_usuario` INT(11) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id_encuesta`) REFERENCES `encuestas`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`id_usuario`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE,
  UNIQUE (`id_encuesta`, `id_usuario`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4;


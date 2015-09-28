/*
 * ELIMINACIÓN DE BASE DE DATOS
 */
-- DROP DATABASE `demo`; --

/*
 * CREACIÓN DE BASE DE DATOS
 */
CREATE DATABASE `demo` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;

/*
 * CONECTARSE DE BASE DE DATOS
 */
USE `demo`;

/*
 * tabla que almacena los datos de los colaboradores del proyecto.
 */
CREATE TABLE IF NOT EXISTS `helpers` 
(
	`id` INT(11) NOT NULL AUTO_INCREMENT,	 
	`name` VARCHAR(50) COLLATE utf8_spanish_ci NOT NULL,  
	`lastname` VARCHAR(50) COLLATE utf8_spanish_ci NOT NULL,  
	`email` VARCHAR(80) COLLATE utf8_spanish_ci NOT NULL,	
	`message` MEDIUMTEXT COLLATE utf8_spanish_ci NOT NULL,
	`created_at` DATE NOT NULL,
	`updated_at` DATE NOT NULL,	
	PRIMARY KEY (`id`)
) 
ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_spanish_ci AUTO_INCREMENT=1;

/*
 * CREACIÓN DE USUARIO 
 */
GRANT ALL ON demo.* TO 'user'@'localhost' IDENTIFIED BY '12345678';

/*
 * RECARGAR PERMISOS EN EL MOTOR DE BDD
 */
FLUSH PRIVILEGES;


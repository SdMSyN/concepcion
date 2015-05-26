ALTER TABLE  `usuarios` ADD  `activo` TINYINT NOT NULL ; /*Añade el campo 'activo' para comprobar si un usuario aún trabaja. */

/* Añade el campo 'activa' a la tabla tiendas */
ALTER TABLE  `tiendas` ADD  `activa` TINYINT NOT NULL ;

/*Altera el formato de la columna precio de la tabla producto para aceptar centavos*/
ALTER TABLE  `productos` CHANGE  `precio`  `precio` FLOAT( 8, 2 ) NOT NULL ;

/* Altera el formato de la tabla categoría */
ALTER TABLE  `categorias` ADD  `activo` TINYINT NOT NULL ;
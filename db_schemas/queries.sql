ALTER TABLE  `usuarios` ADD  `activo` TINYINT NOT NULL ; /*Añade el campo 'activo' para comprobar si un usuario aún trabaja. */

/* Añade el campo 'activa' a la tabla tiendas */
ALTER TABLE  `tiendas` ADD  `activa` TINYINT NOT NULL ;

/*Altera el formato de la columna precio de la tabla producto para aceptar centavos*/
ALTER TABLE  `productos` CHANGE  `precio`  `precio` FLOAT( 8, 2 ) NOT NULL ;

/* Altera el formato de la tabla categoría */
ALTER TABLE  `categorias` ADD  `activo` TINYINT NOT NULL ;

/* Altera la tabla almacén */
ALTER TABLE  `almacenes` ADD  `created` DATE NOT NULL AFTER  `id` ,
ADD  `user_create` INT NOT NULL AFTER  `created` ,
ADD  `updated` DATE NOT NULL AFTER  `user_create` ,
ADD  `user_update` INT NOT NULL AFTER  `updated` ;

/* Alterar la tabla ventas_info */
ALTER TABLE  `ventas_info` ADD  `pago` FLOAT( 8, 2 ) NOT NULL ,
ADD  `total` FLOAT( 8, 2 ) NOT NULL ,
ADD  `cambio` FLOAT( 8, 2 ) NOT NULL ;

/* altera para añadir hora de pedido */

ALTER TABLE `pedidos_info` ADD `hora_entrega_inicial` VARCHAR(5) NOT NULL , ADD `hora_entrega_final` VARCHAR(5) NOT NULL ;
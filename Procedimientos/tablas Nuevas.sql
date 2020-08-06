/*tabla servicios*/
CREATE TABLE IF NOT EXISTS `mydb`.`Servicios` (
  `idServicios` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `descripcion` VARCHAR(200) NULL DEFAULT NULL COMMENT '',
  PRIMARY KEY (`idServicios`)  COMMENT '')
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci


/*tabla servicios por producto*/
CREATE TABLE IF NOT EXISTS `mydb`.`ServiciosPorProducto` (
  `Servicios_idServicios` INT(11) NOT NULL COMMENT '',
  `Producto_idProducto` INT(11) NOT NULL COMMENT '',
  PRIMARY KEY (`Servicios_idServicios`, `Producto_idProducto`)  COMMENT '',
  INDEX `fk_Servicios_has_Producto_Producto1_idx` (`Producto_idProducto` ASC)  COMMENT '',
  INDEX `fk_Servicios_has_Producto_Servicios1_idx` (`Servicios_idServicios` ASC)  COMMENT '',
  CONSTRAINT `fk_Servicios_has_Producto_Servicios1`
    FOREIGN KEY (`Servicios_idServicios`)
    REFERENCES `mydb`.`Servicios` (`idServicios`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Servicios_has_Producto_Producto1`
    FOREIGN KEY (`Producto_idProducto`)
    REFERENCES `mydb`.`Producto` (`idProducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci

/*cambio en categorias*/
ALTER TABLE `mydb`.`Categorias` 
ADD COLUMN `subCategorias` INT(11) NULL DEFAULT NULL COMMENT '' AFTER `descripcion`,
ADD INDEX `fk_Categorias_Categorias1_idx` (`subCategorias` ASC)  COMMENT '';
ALTER TABLE `mydb`.`Categorias` 
ADD CONSTRAINT `fk_Categorias_Categorias1`
  FOREIGN KEY (`subCategorias`);



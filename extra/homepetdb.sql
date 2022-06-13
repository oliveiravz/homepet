CREATE DATABASE IF NOT EXISTS `homepet` DEFAULT CHARACTER SET utf8 ;
USE `homepet` ;

-- -----------------------------------------------------
-- Table `homepet`.`login`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `homepet`.`login` (
  `email` VARCHAR(45) NOT NULL,
  `senha` VARCHAR(60) NOT NULL,
  PRIMARY KEY (`email`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `homepet`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `homepet`.`usuario` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_usuario_login1`
    FOREIGN KEY (`email`)
    REFERENCES `homepet`.`login` (`email`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `homepet`.`telefone`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `homepet`.`telefone` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `telefone` VARCHAR(45) NULL,
  `whatsapp` VARCHAR(45) NULL,
  `usuario_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_telefone_usuario`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `homepet`.`usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `homepet`.`raca`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `homepet`.`raca` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `raca` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `homepet`.`animal`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `homepet`.`animal` (
  `id_animal` INT NOT NULL AUTO_INCREMENT,
  `nome_animal` VARCHAR(45) NOT NULL,
  `peso` DECIMAL(5,2) NOT NULL,
  `porte` VARCHAR(45) NOT NULL,
  `descricao` TEXT NOT NULL,
  `usuario_id` INT NOT NULL,
  `raca_id` INT NOT NULL,
  `imagem` BLOB NULL,
  `created` DATE NULL,
  PRIMARY KEY (`id_animal`),
  CONSTRAINT `fk_animal_usuario1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `homepet`.`usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_animal_raca1`
    FOREIGN KEY (`raca_id`)
    REFERENCES `homepet`.`raca` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `homepet`.`endereco`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `homepet`.`endereco` (
  `usuario_id` INT NOT NULL AUTO_INCREMENT,
  `estado` VARCHAR(45) NOT NULL,
  `cidade` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`usuario_id`),
  CONSTRAINT `fk_endereco_usuario1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `homepet`.`usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


INSERT INTO raca(raca) VALUES('Boxer'), ('Sem raça definida'), ('Pitbull'),('Rotweiller');
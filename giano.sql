-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema giano
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `giano` ;

-- -----------------------------------------------------
-- Schema giano
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `giano` DEFAULT CHARACTER SET utf8 ;
USE `giano` ;

-- -----------------------------------------------------
-- Table `giano`.`type_device`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `giano`.`type_device` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `giano`.`devices`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `giano`.`devices` (
  `id` INT(255) NOT NULL AUTO_INCREMENT,
  `name` TEXT NOT NULL,
  `active` INT(11) NOT NULL DEFAULT '0',
  `type` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_devices_1_idx` (`type` ASC),
  CONSTRAINT `fk_type_device`
    FOREIGN KEY (`type`)
    REFERENCES `giano`.`type_device` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `giano`.`log`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `giano`.`log` (
  `id` INT(25) NOT NULL AUTO_INCREMENT,
  `userid` INT(225) NOT NULL,
  `cardcode` TEXT NOT NULL,
  `date_log` DATETIME NOT NULL,
  `devicelog` INT(255) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `giano`.`permissions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `giano`.`permissions` (
  `id` INT(11) NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `insert_devices` TINYINT(4) NOT NULL DEFAULT 0,
  `insert_tags` TINYINT(4) NOT NULL DEFAULT 0,
  `insert_users` TINYINT(4) NOT NULL DEFAULT 0,
  `delete_devices` TINYINT(4) NOT NULL DEFAULT 0,
  `delete_tags` TINYINT(4) NOT NULL DEFAULT 0,
  `delete_users` TINYINT(4) NOT NULL DEFAULT 0,
  `insert_reservation` TINYINT(4) NOT NULL DEFAULT 0,
  `delete_reservation` TINYINT(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `giano`.`system`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `giano`.`system` (
  `site name` MEDIUMTEXT NOT NULL,
  `site url` TEXT NOT NULL,
  `status` ENUM('0', '1') NOT NULL DEFAULT '0')
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `giano`.`type_user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `giano`.`type_user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `level` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `giano`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `giano`.`users` (
  `userid` INT(25) NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(25) NOT NULL DEFAULT '',
  `email_address` VARCHAR(25) NULL DEFAULT '',
  `username` VARCHAR(25) NOT NULL DEFAULT '',
  `PASSWORD` VARCHAR(255) NOT NULL DEFAULT '',
  `info` TEXT NULL,
  `user_level` INT NOT NULL DEFAULT '3',
  `signup_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `activated` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`userid`),
  INDEX `fk_user_level_idx` (`user_level` ASC),
  CONSTRAINT `fk_user_level`
    FOREIGN KEY (`user_level`)
    REFERENCES `giano`.`type_user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 30
DEFAULT CHARACTER SET = latin1
COMMENT = 'Membership Information';


-- -----------------------------------------------------
-- Table `giano`.`tags`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `giano`.`tags` (
  `id` INT(25) NOT NULL AUTO_INCREMENT,
  `cardcode` TEXT NOT NULL,
  `userid` INT NULL,
  `status` INT(255) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_userid_tags_idx` (`userid` ASC),
  CONSTRAINT `fk_userid_tags`
    FOREIGN KEY (`userid`)
    REFERENCES `giano`.`users` (`userid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `giano`.`reservation`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `giano`.`reservation` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `deviceid` INT NOT NULL,
  `userid` INT NOT NULL,
  `from_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `to_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`, `deviceid`, `userid`),
  INDEX `fk_reservation_userid_idx` (`userid` ASC),
  INDEX `fk_reservation_deviceid_idx` (`deviceid` ASC),
  CONSTRAINT `fk_reservation_userid`
    FOREIGN KEY (`userid`)
    REFERENCES `giano`.`users` (`userid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_reservation_deviceid`
    FOREIGN KEY (`deviceid`)
    REFERENCES `giano`.`devices` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Data for table `giano`.`type_device`
-- -----------------------------------------------------
START TRANSACTION;
USE `giano`;
INSERT INTO `giano`.`type_device` (`id`, `name`) VALUES (1, 'Porta');

COMMIT;


-- -----------------------------------------------------
-- Data for table `giano`.`devices`
-- -----------------------------------------------------
START TRANSACTION;
USE `giano`;
INSERT INTO `giano`.`devices` (`id`, `name`, `active`, `type`) VALUES (1, 'Ingresso', 1, 1);
INSERT INTO `giano`.`devices` (`id`, `name`, `active`, `type`) VALUES (2, 'Sala Riunioni', 1, 1);

COMMIT;


-- -----------------------------------------------------
-- Data for table `giano`.`permissions`
-- -----------------------------------------------------
START TRANSACTION;
USE `giano`;
INSERT INTO `giano`.`permissions` (`id`, `name`, `insert_devices`, `insert_tags`, `insert_users`, `delete_devices`, `delete_tags`, `delete_users`, `insert_reservation`, `delete_reservation`) VALUES (1, 'administration', 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `giano`.`permissions` (`id`, `name`, `insert_devices`, `insert_tags`, `insert_users`, `delete_devices`, `delete_tags`, `delete_users`, `insert_reservation`, `delete_reservation`) VALUES (2, 'manager', 1, 1, 1, 0, 0, 0, 1, 1);
INSERT INTO `giano`.`permissions` (`id`, `name`, `insert_devices`, `insert_tags`, `insert_users`, `delete_devices`, `delete_tags`, `delete_users`, `insert_reservation`, `delete_reservation`) VALUES (3, 'user', 0, 0, 0, 0, 0, 0, 1, 1);

COMMIT;


-- -----------------------------------------------------
-- Data for table `giano`.`type_user`
-- -----------------------------------------------------
START TRANSACTION;
USE `giano`;
INSERT INTO `giano`.`type_user` (`id`, `level`) VALUES (1, 'administrator');
INSERT INTO `giano`.`type_user` (`id`, `level`) VALUES (2, 'manager');
INSERT INTO `giano`.`type_user` (`id`, `level`) VALUES (3, 'user');

COMMIT;


-- -----------------------------------------------------
-- Data for table `giano`.`users`
-- -----------------------------------------------------
START TRANSACTION;
USE `giano`;
INSERT INTO `giano`.`users` (`userid`, `first_name`, `email_address`, `username`, `PASSWORD`, `info`, `user_level`, `signup_date`, `end_date`, `last_login`, `activated`) VALUES (1, 'admin', 'admin@fb7.it', 'admin', '6e6bc4e49dd477ebc98ef4046c067b5f', 'Fablab', 1, DEFAULT, DEFAULT, DEFAULT, 1);
INSERT INTO `giano`.`users` (`userid`, `first_name`, `email_address`, `username`, `PASSWORD`, `info`, `user_level`, `signup_date`, `end_date`, `last_login`, `activated`) VALUES (2, 'manager', 'manager@fb7.it', 'manager', '6e6bc4e49dd477ebc98ef4046c067b5f', 'Fablab', 2, DEFAULT, DEFAULT, DEFAULT, 1);
INSERT INTO `giano`.`users` (`userid`, `first_name`, `email_address`, `username`, `PASSWORD`, `info`, `user_level`, `signup_date`, `end_date`, `last_login`, `activated`) VALUES (3, 'user', 'user@fb7.it', 'user', '6e6bc4e49dd477ebc98ef4046c067b5f', 'Fablab', 3, DEFAULT, DEFAULT, DEFAULT, DEFAULT);

COMMIT;


-- -----------------------------------------------------
-- Data for table `giano`.`tags`
-- -----------------------------------------------------
START TRANSACTION;
USE `giano`;
INSERT INTO `giano`.`tags` (`id`, `cardcode`, `userid`, `status`) VALUES (1, '112314', 1, 1);
INSERT INTO `giano`.`tags` (`id`, `cardcode`, `userid`, `status`) VALUES (2, '4324', 2, 1);
INSERT INTO `giano`.`tags` (`id`, `cardcode`, `userid`, `status`) VALUES (3, '47beet', 3, 1);

COMMIT;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `ruffythe_greencompass`.`batches`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ruffythe_greencompass`.`batches` ;

CREATE  TABLE IF NOT EXISTS `ruffythe_greencompass`.`batches` (
  `batchid` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `startdate` DATETIME NULL DEFAULT NULL ,
  `createddate` DATETIME NOT NULL ,
  PRIMARY KEY (`batchid`) )
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ruffythe_greencompass`.`batchschools`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ruffythe_greencompass`.`batchschools` ;

CREATE  TABLE IF NOT EXISTS `ruffythe_greencompass`.`batchschools` (
  `batchschoolid` INT(11) NOT NULL AUTO_INCREMENT ,
  `schoolid` INT(11) NOT NULL ,
  `batchid` INT(11) NOT NULL ,
  `createddate` DATETIME NOT NULL ,
  PRIMARY KEY (`batchschoolid`) )
ENGINE = InnoDB
AUTO_INCREMENT = 10
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ruffythe_greencompass`.`batchteachers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ruffythe_greencompass`.`batchteachers` ;

CREATE  TABLE IF NOT EXISTS `ruffythe_greencompass`.`batchteachers` (
  `batchteacherid` INT(11) NOT NULL AUTO_INCREMENT ,
  `userid` INT(11) NOT NULL ,
  `batchid` INT(11) NOT NULL ,
  `createddate` DATETIME NOT NULL ,
  PRIMARY KEY (`batchteacherid`) )
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ruffythe_greencompass`.`batchworkshopfiles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ruffythe_greencompass`.`batchworkshopfiles` ;

CREATE  TABLE IF NOT EXISTS `ruffythe_greencompass`.`batchworkshopfiles` (
  `batchworkshopfileid` INT(10) NOT NULL AUTO_INCREMENT ,
  `batchworkshopid` INT(10) NOT NULL ,
  `languageid` INT(10) NULL DEFAULT NULL ,
  `filename` VARCHAR(100) NOT NULL ,
  `size` INT(10) NOT NULL ,
  `userid` INT(10) NOT NULL ,
  `createddate` DATETIME NOT NULL ,
  PRIMARY KEY (`batchworkshopfileid`) )
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ruffythe_greencompass`.`batchworkshops`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ruffythe_greencompass`.`batchworkshops` ;

CREATE  TABLE IF NOT EXISTS `ruffythe_greencompass`.`batchworkshops` (
  `batchworkshopid` INT(11) NOT NULL AUTO_INCREMENT ,
  `batchid` INT(11) NOT NULL ,
  `workshopid` INT(11) NOT NULL ,
  `publishdate` DATETIME NULL DEFAULT NULL ,
  `createddate` DATETIME NOT NULL ,
  PRIMARY KEY (`batchworkshopid`) )
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ruffythe_greencompass`.`countries`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ruffythe_greencompass`.`countries` ;

CREATE  TABLE IF NOT EXISTS `ruffythe_greencompass`.`countries` (
  `countryid` INT(10) NOT NULL ,
  `name` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`countryid`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ruffythe_greencompass`.`languages`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ruffythe_greencompass`.`languages` ;

CREATE  TABLE IF NOT EXISTS `ruffythe_greencompass`.`languages` (
  `languageid` INT(10) NOT NULL ,
  `name` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`languageid`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ruffythe_greencompass`.`news`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ruffythe_greencompass`.`news` ;

CREATE  TABLE IF NOT EXISTS `ruffythe_greencompass`.`news` (
  `newsid` INT(10) NOT NULL AUTO_INCREMENT ,
  `userid` INT(10) NOT NULL ,
  `text` MEDIUMTEXT NOT NULL ,
  `ispublished` BIT(1) NOT NULL ,
  `created` DATETIME NOT NULL ,
  PRIMARY KEY (`newsid`) )
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ruffythe_greencompass`.`pages`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ruffythe_greencompass`.`pages` ;

CREATE  TABLE IF NOT EXISTS `ruffythe_greencompass`.`pages` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `menulabel` VARCHAR(50) NULL DEFAULT NULL ,
  `content` TEXT NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ruffythe_greencompass`.`roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ruffythe_greencompass`.`roles` ;

CREATE  TABLE IF NOT EXISTS `ruffythe_greencompass`.`roles` (
  `id` INT(11) NOT NULL ,
  `name` VARCHAR(50) NOT NULL ,
  `value` VARCHAR(10) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ruffythe_greencompass`.`schools`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ruffythe_greencompass`.`schools` ;

CREATE  TABLE IF NOT EXISTS `ruffythe_greencompass`.`schools` (
  `schoolid` INT(10) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(50) NOT NULL ,
  `countryid` INT(10) NULL DEFAULT NULL ,
  `createddate` DATETIME NOT NULL ,
  PRIMARY KEY (`schoolid`) )
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ruffythe_greencompass`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ruffythe_greencompass`.`users` ;

CREATE  TABLE IF NOT EXISTS `ruffythe_greencompass`.`users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(50) NULL DEFAULT NULL ,
  `password` CHAR(40) NULL DEFAULT NULL ,
  `schoolid` INT(10) NULL DEFAULT NULL ,
  `languageid` INT(10) NULL DEFAULT NULL ,
  `email` VARCHAR(100) NOT NULL ,
  `isactivated` BIT(1) NOT NULL DEFAULT b'0' ,
  `verificationcode` VARCHAR(32) NULL DEFAULT NULL ,
  `created` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 16
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ruffythe_greencompass`.`users_in_roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ruffythe_greencompass`.`users_in_roles` ;

CREATE  TABLE IF NOT EXISTS `ruffythe_greencompass`.`users_in_roles` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `user_id` INT(11) NOT NULL ,
  `role_id` INT(11) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `user_id` (`user_id` ASC) ,
  INDEX `role_id` (`role_id` ASC) ,
  CONSTRAINT `users_in_roles_ibfk_1`
    FOREIGN KEY (`user_id` )
    REFERENCES `ruffythe_greencompass`.`users` (`id` ),
  CONSTRAINT `users_in_roles_ibfk_2`
    FOREIGN KEY (`role_id` )
    REFERENCES `ruffythe_greencompass`.`roles` (`id` ))
ENGINE = InnoDB
AUTO_INCREMENT = 9
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ruffythe_greencompass`.`workshopfiles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ruffythe_greencompass`.`workshopfiles` ;

CREATE  TABLE IF NOT EXISTS `ruffythe_greencompass`.`workshopfiles` (
  `workshopfileid` INT(10) NOT NULL AUTO_INCREMENT ,
  `workshopid` INT(10) NOT NULL ,
  `languageid` INT(10) NULL DEFAULT NULL ,
  `filename` VARCHAR(100) NOT NULL ,
  `size` INT(10) NOT NULL ,
  `userid` INT(10) NOT NULL ,
  `createddate` DATETIME NOT NULL ,
  PRIMARY KEY (`workshopfileid`) ,
  UNIQUE INDEX `NameAndKey` (`filename` ASC, `workshopid` ASC) ,
  INDEX `userid_idx` (`userid` ASC) ,
  CONSTRAINT `userid`
    FOREIGN KEY (`userid` )
    REFERENCES `ruffythe_greencompass`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ruffythe_greencompass`.`workshops`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ruffythe_greencompass`.`workshops` ;

CREATE  TABLE IF NOT EXISTS `ruffythe_greencompass`.`workshops` (
  `workshopid` INT(10) NOT NULL AUTO_INCREMENT ,
  `workshopname` VARCHAR(30) NOT NULL ,
  `createddate` DATETIME NOT NULL ,
  PRIMARY KEY (`workshopid`) )
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ruffythe_greencompass`.`workshoptranslations`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ruffythe_greencompass`.`workshoptranslations` ;

CREATE  TABLE IF NOT EXISTS `ruffythe_greencompass`.`workshoptranslations` (
  `workshoptranslationid` INT(10) NOT NULL AUTO_INCREMENT ,
  `workshopid` INT(10) NOT NULL ,
  `languageid` INT(10) NOT NULL ,
  `background` TEXT NULL DEFAULT NULL ,
  `goals` TEXT NULL DEFAULT NULL ,
  `expectedresults` TEXT NULL DEFAULT NULL ,
  `timeline` TEXT NULL DEFAULT NULL ,
  `createddate` DATETIME NOT NULL ,
  `title` VARCHAR(50) NULL DEFAULT NULL ,
  PRIMARY KEY (`workshoptranslationid`) ,
  UNIQUE INDEX `workshoptranslationid_UNIQUE` (`workshoptranslationid` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 12
DEFAULT CHARACTER SET = utf8;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

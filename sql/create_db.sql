-- MySQL Script generated by MySQL Workbench
-- 11/19/14 13:55:34
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema toystore
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema toystore
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `toystore` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `toystore` ;

-- -----------------------------------------------------
-- Table `toystore`.`User`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `toystore`.`User` ;

CREATE TABLE IF NOT EXISTS `toystore`.`User` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Email` VARCHAR(255) NOT NULL,
  `Name` VARCHAR(255) NOT NULL,
  `BillingAddress` VARCHAR(255) NOT NULL,
  `ShippingAddress` VARCHAR(255) NOT NULL,
  `Password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE INDEX `Email_UNIQUE` (`Email` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `toystore`.`Category`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `toystore`.`Category` ;

CREATE TABLE IF NOT EXISTS `toystore`.`Category` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`Id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `toystore`.`Order`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `toystore`.`Order` ;

CREATE TABLE IF NOT EXISTS `toystore`.`Order` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `OrderDate` DATE NOT NULL,
  `Total` DECIMAL(10,2) NULL,
  `Status` VARCHAR(45) NOT NULL,
  `UserId` INT NOT NULL,
  PRIMARY KEY (`Id`),
  INDEX `Order_UserId_FK_idx` (`UserId` ASC),
  CONSTRAINT `Order_UserId_FK`
    FOREIGN KEY (`UserId`)
    REFERENCES `toystore`.`User` (`Id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `toystore`.`Product`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `toystore`.`Product` ;

CREATE TABLE IF NOT EXISTS `toystore`.`Product` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(255) NOT NULL,
  `Description` VARCHAR(2000) NOT NULL,
  `Price` DECIMAL(10,2) NOT NULL,
  `Inventory` INT NOT NULL,
  `Picture` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`Id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `toystore`.`OrderItem`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `toystore`.`OrderItem` ;

CREATE TABLE IF NOT EXISTS `toystore`.`OrderItem` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `OrderId` INT NOT NULL,
  `ProductId` INT NOT NULL,
  `Quantity` INT NOT NULL,
  `Price` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`Id`),
  INDEX `OrderItem_Order_idx` (`OrderId` ASC),
  INDEX `OrderItem_Product_idx` (`ProductId` ASC),
  CONSTRAINT `OrderItem_Order`
    FOREIGN KEY (`OrderId`)
    REFERENCES `toystore`.`Order` (`Id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `OrderItem_Product`
    FOREIGN KEY (`ProductId`)
    REFERENCES `toystore`.`Product` (`Id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `toystore`.`ProductToCategory`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `toystore`.`ProductToCategory` ;

CREATE TABLE IF NOT EXISTS `toystore`.`ProductToCategory` (
  `ProductId` INT NOT NULL,
  `CategoryId` INT NOT NULL,
  PRIMARY KEY (`ProductId`, `CategoryId`),
  INDEX `PTC_CategoryId_idx` (`CategoryId` ASC),
  CONSTRAINT `PTC_ProductId`
    FOREIGN KEY (`ProductId`)
    REFERENCES `toystore`.`Product` (`Id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `PTC_CategoryId`
    FOREIGN KEY (`CategoryId`)
    REFERENCES `toystore`.`Category` (`Id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

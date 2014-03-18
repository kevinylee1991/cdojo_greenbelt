SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `expenses` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `expenses` ;

-- -----------------------------------------------------
-- Table `expenses`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `expenses`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `budget` INT NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `expenses`.`expenses`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `expenses`.`expenses` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `users_id` INT NOT NULL,
  `date` DATETIME NULL,
  `particulars` VARCHAR(255) NULL,
  `amount_spent` INT NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_expenses_users_idx` (`users_id` ASC),
  CONSTRAINT `fk_expenses_users`
    FOREIGN KEY (`users_id`)
    REFERENCES `expenses`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

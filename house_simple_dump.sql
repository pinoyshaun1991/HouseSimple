CREATE DATABASE `house_simple`;
CREATE TABLE `house_simple`.`urls` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'URL ID.',
  `url_destination` VARCHAR(255) NOT NULL COMMENT 'Destination of URL.',
  `url_short` VARCHAR(45) NOT NULL COMMENT 'Short version of URL.',
  PRIMARY KEY (`id`));
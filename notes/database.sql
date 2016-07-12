CREATE TABLE `guestbook`.`comments` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `date` VARCHAR(15) NOT NULL,
  `time` VARCHAR(15) NOT NULL,
  `name` VARCHAR(50) NOT NULL,
  `email` VARCHAR(50) NOT NULL,
  `comment` VARCHAR(500) NOT NULL,
  PRIMARY KEY (`id`));
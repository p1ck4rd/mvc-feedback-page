CREATE TABLE `feedback`.`message` ( `id` INT NOT NULL AUTO_INCREMENT , `author_name` VARCHAR(30) NOT NULL , `author_email` VARCHAR(30) NOT NULL , `text` VARCHAR(500) NOT NULL , `picture` VARCHAR(100) NOT NULL , `date` DATE NOT NULL , `changed` BOOLEAN NOT NULL DEFAULT FALSE , `allowed` BOOLEAN NULL DEFAULT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

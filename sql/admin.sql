CREATE TABLE `feedback`.`admin` ( `id` INT NOT NULL AUTO_INCREMENT , `login` VARCHAR(20) NOT NULL , `password` VARCHAR(32) NOT NULL , `salt` VARCHAR(20) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB; 
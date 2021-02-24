DROP DATABASE IF EXISTS `BobiJump`;

BEGIN;
CREATE DATABASE IF NOT EXISTS `BobiJump`;
COMMIT;

USE `BobiJump`;

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
	`username` VARCHAR(32) NOT NULL UNIQUE,
	`email` VARCHAR(255) NOT NULL UNIQUE,
	`password` VARCHAR(255) NOT NULL,
	`highscore` INT,
	`currentSkin` INT NOT NULL DEFAULT 1,
	PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `characters`;
CREATE TABLE `characters` (
	`characterId` INT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(32) NOT NULL UNIQUE,
	`path` VARCHAR(255) NOT NULL,
	`velocity` INT NOT NULL,
	PRIMARY KEY (`characterId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `unlocked`;
CREATE TABLE `unlocked` (
	`username` VARCHAR(32) NOT NULL,
	`characterId` INT NOT NULL,
	`time` INT,
	PRIMARY KEY (`username`, `characterId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `user`
VALUES 
	('root', 'bobi@bobi.it', '$2y$10$8xWEuneugVKO9CAAE9ELruaAs0.24lJMsHYXLDePM25sgWJWvDNjC', 54000, DEFAULT), 
	('dummy1', 'q@q.it', '$2y$10$2zZwoGTnYNKxghEZQUQ8BeYjvJwMwRS/y27quvJqcWmGVM8DeUC5m', 15141, DEFAULT),
	('dummy2', 'x@x.it', '$2y$10$XtglD6bfXysmdfLndtwLWOR4ZG1nQ4YnMDN8h91TnLMPZN2o.feTe', 76676, DEFAULT);

INSERT INTO `characters` (`name`, `path`, `velocity`)
VALUES ('larry', '../images/larry.png', -20), ('clown', '../images/clown.png', -22), ('trump', '../images/trump.gif', -24);

INSERT INTO `unlocked`
VALUES 
	('root', 1, 100), ('root', 2, 247), ('root', 3, 240),
	('dummy1', 1, 175),
	('dummy2', 1, 152), ('dummy2', 2, 131), ('dummy2', 3, 311);
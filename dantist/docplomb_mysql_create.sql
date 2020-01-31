CREATE TABLE `staff` (
	`empID` int NOT NULL AUTO_INCREMENT,
	`surname` varchar(50) NOT NULL,
	`name` varchar(50) NOT NULL,
	`patronym` varchar(50) NOT NULL,
	`speciality` varchar(50) NOT NULL,
	`picture` varchar(255) NOT NULL,
	PRIMARY KEY (`empID`)
);

CREATE TABLE `services` (
	`serID` bigint NOT NULL AUTO_INCREMENT,
	`service` varchar(50) NOT NULL,
	`description` TEXT NOT NULL,
	`price` DECIMAL NOT NULL,
	PRIMARY KEY (`serID`)
);

CREATE TABLE `contacts` (
	`conID` int NOT NULL AUTO_INCREMENT,
	`time_start` varchar(5) NOT NULL,
	`time_end` varchar(5) NOT NULL,
	`address` TEXT NOT NULL,
	`phones` TEXT NOT NULL,
	`email` varchar(25) NOT NULL,
	PRIMARY KEY (`conID`)
);


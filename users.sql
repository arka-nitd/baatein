
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone="+05:30";

CREATE TABLE IF NOT EXISTS 'users' (
	'id' int(11) NOT NULL AUTO_INCREMENT,
	'username' varchar(255) NOT NULL,
	'firstname' varchar(255) NOT NULL,
	'lastname' varchar(255) NOT NULL,
	'email' varchar(255) NOT NULL,
	'password' varchar(32) NOT NULL,
	'sign_up_date' date NOT NULL,
	'activated' enum('0','1') NOT NULL,
	PRIMARY KEY ('id')	
)	ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";



SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone="+05:30";

CREATE TABLE IF NOT EXISTS posts (
	id int(11) NOT NULL AUTO_INCREMENT,
	body text NOT NULL,
	date_added date NOT NULL,
	added_by varchar(255) NOT NULL,
	user_posted_to varchar(255) NOT NULL,
	PRIMARY KEY (id)	
)	ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=10;
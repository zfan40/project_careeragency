CREATE TABLE IF NOT EXISTS `users` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(50),
  `FirstName` varchar(50),
  `LastName` varchar(50),
  `Email` varchar(50),
  `Password` varchar(50),
  PRIMARY KEY (`UserID`)
); 


CREATE TABLE IF NOT EXISTS `companies` (
  `CompanyID` int(11) NOT NULL AUTO_INCREMENT,
  `CompanyName` varchar(50),
  `CompanyPage` varchar(255),
  `CompanyLogo` varchar(50),
  `CompanyStaff` int(11),
  `CompanyDescription` text,
  `AverageRate` float(10),
  PRIMARY KEY (`CompanyID`)
); 


CREATE TABLE IF NOT EXISTS `locations`(
	`LocationID` int(11) NOT NULL AUTO_INCREMENT,
	`State` varchar(50),
	`City` varchar(50),
	PRIMARY KEY (`LocationID`)
);


CREATE TABLE if NOT EXISTS `fields`(
	`FieldID` int(11) NOT NULL AUTO_INCREMENT,
	`Field` varchar(50),
	PRIMARY KEY (`FieldID`)
);

-- one user to many rates
CREATE TABLE IF NOT EXISTS `userrates`	(
	`RateID` int(11) NOT NULL AUTO_INCREMENT,
	`UserID` int(11) NOT NULL,
	`CompanyID` int(11) NOT NULL,
	`Star`	 int(11) NOT NULL,
	PRIMARY KEY (`RateID`),
	FOREIGN KEY (`UserID`) REFERENCES users(`UserID`),
	FOREIGN KEY (`CompanyID`) REFERENCES companies(`CompanyID`)
);


CREATE TABLE if NOT EXISTS `company_locations`(
	`ComlocID` int(11) NOT NULL AUTO_INCREMENT,
	`CompanyID` int(11) NOT NULL,
	`LocationID` int(11) NOT NULL,
	PRIMARY KEY (`ComlocID`),
	FOREIGN KEY (`CompanyID`) REFERENCES users(`UserID`),
	FOREIGN KEY (`LocationID`) REFERENCES locations(`LocationID`)
);

CREATE TABLE if NOT EXISTS `company_fields`(
	`ComfieldID` int(11) NOT NULL AUTO_INCREMENT,
	`CompanyID` int(11) NOT NULL,
	`FieldID` int(11) NOT NULL,
	PRIMARY KEY (`ComfieldID`),
	FOREIGN KEY (`CompanyID`) REFERENCES companies(`CompanyID`),
	FOREIGN KEY (`FieldID`) REFERENCES fields(`FieldID`)
);

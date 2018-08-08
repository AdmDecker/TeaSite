CREATE TABLE users
(
	userID int NOT NULL AUTO_INCREMENT,
	userName VARCHAR(255) NOT NULL,
	password VARCHAR(255) NOT NULL,
    role CHAR,
    teas int,
    timeOfNextOrder int,
	email VARCHAR(80),
	PRIMARY KEY (userID)
);

/*test data*/
INSERT INTO users VALUES(1337, "TestCustomer", "$2y$10$YhcXJOg.Y2KwOAd5MrZZX.qlWlvRql8xn50cbVotU9lajyhp1qNsS", "C");
INSERT INTO users VALUES(1338, "TestDriver", "$2y$10$YhcXJOg.Y2KwOAd5MrZZX.qlWlvRql8xn50cbVotU9lajyhp1qNsS", "D");

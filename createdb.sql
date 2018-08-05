CREATE TABLE users
(
	userID int NOT NULL AUTO_INCREMENT,
	userName VARCHAR(255) NOT NULL,
	password VARCHAR(255) NOT NULL,
    role CHAR,
    teas int,
	PRIMARY KEY (userID)
);

CREATE TABLE customers
(
    userID int NOT NULL AUTO_INCREMENT,
    FOREIGN KEY(userID) REFERENCES users(userID) ON DELETE CASCADE,
    homeAddress VARCHAR(255),
    phoneNumber VARCHAR(25),
    email VARCHAR(50)
);

CREATE TABLE userInfo
(
    userInfoID int NOT NULL AUTO_INCREMENT,
    user int NOT NULL,
    FOREIGN KEY (user) REFERENCES users(userID) ON DELETE CASCADE,
    name VARCHAR(255),
    email VARCHAR(255),
    PRIMARY KEY(userInfoID)
);

/*test data*/
INSERT INTO users VALUES(1337, "TestCustomer", "$2y$10$YhcXJOg.Y2KwOAd5MrZZX.qlWlvRql8xn50cbVotU9lajyhp1qNsS", "C");
INSERT INTO users VALUES(1338, "TestDriver", "$2y$10$YhcXJOg.Y2KwOAd5MrZZX.qlWlvRql8xn50cbVotU9lajyhp1qNsS", "D");
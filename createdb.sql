CREATE TABLE users
(
    userID int NOT NULL AUTO_INCREMENT,
    userName VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role CHAR,
    teas int,
    timeOfNextOrder int,
    email VARCHAR(80),
    emailEnabled BOOL,
    PRIMARY KEY (userID)
);

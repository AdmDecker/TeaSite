CREATE TABLE users
(
    userID int NOT NULL AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role CHAR,
    teas int,
    timeOfNextOrder int,
    email VARCHAR(80),
    emailEnabled BOOL,
    loginCookie int,
    PRIMARY KEY (userID)
);
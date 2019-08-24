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
    loginCookie VARCHAR(255),
    PRIMARY KEY (userID)
);

CREATE TABLE transactions
(
    transactionID int NOT NULL AUTO_INCREMENT,
    userID int NOT NULL,
    timestamp int,

    PRIMARY KEY(transactionID),
    FOREIGN KEY(userID) REFERENCES users(userID)
);
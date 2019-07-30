DROP DATABASE IF EXISTS HoshiLe;
CREATE DATABASE HoshiLe;

USE HoshiLe;

CREATE TABLE Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    shoppingCart TEXT,
    isAdmin bit
);

CREATE TABLE Products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    brand VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    imageUrl VARCHAR(255) NOT NULL
);

CREATE TABLE OrderHeads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    userId INT NOT NULL REFERENCES User (id),
    createDate DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE OrderDetails (
    orderId INT NOT NULL REFERENCES OrderHead (id),
    detailId INT NOT NULL,
    productId INT NOT NULL REFERENCES Product (id),
    quantity INT NOT NULL,
    PRIMARY KEY (orderId, detailId)
);

CREATE DATABASE lcsdb;

USE lcsdb;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    status ENUM('on', 'off') DEFAULT 'off'
);

CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    senid INT NOT NULL,
    recid INT NOT NULL,
    message TEXT NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (senid) REFERENCES users(id),
    FOREIGN KEY (recid) REFERENCES users(id)
);

CREATE TABLE inoutlog (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    action VARCHAR(10) NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

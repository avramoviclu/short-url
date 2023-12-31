CREATE DATABASE IF NOT EXISTS short_url;

USE short_url;

CREATE TABLE IF NOT EXISTS url (
    id INT PRIMARY KEY AUTO_INCREMENT,
    short_url VARCHAR(7) NOT NULL,
    long_url TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
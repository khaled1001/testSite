CREATE DATABASE IF NOT EXISTS idea_pool;
USE idea_pool;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    password_hash VARCHAR(255) NOT NULL
);

CREATE TABLE requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    details TEXT NOT NULL,
    benefit TEXT,
    status ENUM('Open', 'Under Review', 'Completed') DEFAULT 'Open',
    claimed_by INT DEFAULT NULL,
    submitted_name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (claimed_by) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE votes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ip_address VARCHAR(45) NOT NULL,
    request_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(ip_address, request_id),
    FOREIGN KEY (request_id) REFERENCES requests(id) ON DELETE CASCADE
);
``

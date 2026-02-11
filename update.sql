CREATE DATABASE IF NOT EXISTS eunoiaverse_db;
USE eunoiaverse_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert a dummy record to test the update
INSERT INTO users (username, email) VALUES ('edoe_erpino7', 'edoerpino7@gmail.com');
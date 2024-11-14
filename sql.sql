CREATE DATABASE PHPMailer;

USE PHPMailer;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(15),
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    verify_token VARCHAR(255),
    verify_status TINYINT(2) DEFAULT 0 COMMENT "1 nếu đã verified, 0 nếu chưa",
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
CREATE TABLE session (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    session_token VARCHAR(255) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
CREATE TABLE `track` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    recipient varchar(255) NOT NULL,
    create_dt datetime NOT NULL,
    read_dt datetime DEFAULT NULL
)



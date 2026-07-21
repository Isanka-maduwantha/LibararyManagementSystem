CREATE DATABASE IF NOT EXISTS library_db;
USE library_db;

CREATE TABLE librarians (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    isbn VARCHAR(50) NOT NULL,
    genre VARCHAR(100) NOT NULL,
    copies INT NOT NULL DEFAULT 1,
    cover_image VARCHAR(255) NULL
);

CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    book_id INT NOT NULL,
    student_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    required_date DATE NOT NULL,
    return_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
);

INSERT INTO librarians (username, password) 
VALUES ('admin', '$2y$10$4.a5dJvD6U6F1yZzQ7E5u.W5F/5t1r1Q9k1R3u5F1yZzQ7E5u.W5F');
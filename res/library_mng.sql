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
INSERT INTO books (title, author, isbn, genre, copies, cover_image) VALUES
('PHP & MySQL Novice to Ninja', 'Kevin Yank', '978-0987153012', 'Web Development', 5, 'php_ninja.jpg'),
('Clean Code', 'Robert C. Martin', '978-0132350884', 'Software Engineering', 2, 'clean_code.jpg'),
('Head First Java', 'Kathy Sierra & Bert Bates', '978-0596009205', 'Programming', 0, 'head_first_java.jpg'),
('Database System Concepts', 'Abraham Silberschatz', '978-0073523323', 'Database', 4, 'db_concepts.jpg'),
('Learning Web Design', 'Jennifer Robbins', '978-1491960202', 'UI/UX Design', 3, 'web_design.jpg'),
('Introduction to Algorithms', 'Thomas H. Cormen', '978-0262033848', 'Computer Science', 1, 'algorithms.jpg');
INSERT INTO librarians (username, password) 
VALUES ('admin', '$2y$10$4.a5dJvD6U6F1yZzQ7E5u.W5F/5t1r1Q9k1R3u5F1yZzQ7E5u.W5F');
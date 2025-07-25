CREATE DATABASE IF NOT EXISTS student_portal_0362506;
USE student_portal_0362506;

CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    course VARCHAR(100),
    profile_pic VARCHAR(255)
);

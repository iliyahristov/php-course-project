CREATE DATABASE university;
USE university;

CREATE TABLE student
(
    id             INT AUTO_INCREMENT PRIMARY KEY,
    first_name     VARCHAR(50)        NOT NULL,
    last_name      VARCHAR(50)        NOT NULL,
    faculty_number VARCHAR(20) UNIQUE NOT NULL,
    created_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE lecture
(
    id         INT AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE student_lecture
(
    student_id INT,
    lecture_id INT,
    FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE,
    FOREIGN KEY (lecture_id) REFERENCES lecture (id) ON DELETE CASCADE,
    PRIMARY KEY (student_id, lecture_id)
);

INSERT INTO student (first_name, last_name, faculty_number)
VALUES ('Ivan', 'Ivanov', 'F12345'),
       ('Petar', 'Petrov', 'F67890');

INSERT INTO lecture (name)
VALUES ('Mathematics'),
       ('Physics'),
       ('Informatics'),
       ('Chemistry');

INSERT INTO student_lecture (student_id, lecture_id)
VALUES (1, 1),
       (1, 3),
       (2, 2);
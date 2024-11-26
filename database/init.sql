CREATE DATABASE IF NOT EXISTS ormdatabase;

USE ormdatabase;

CREATE TABLE IF NOT EXISTS `news` (
    id VARCHAR(36) NOT NULL PRIMARY KEY,
    content VARCHAR(256) NOT NULL,
    created_at DATETIME NOT NULL        
);

-- Insertion de données de test

INSERT INTO `news` (id, content, created_at) VALUES
                                                       ('1', 'Premier article de nouvelles.', '2024-11-26 12:30:00'),
                                                       ('2', 'Deuxième article de nouvelles.', '2024-11-26 12:35:00'),
                                                       ('3', 'Troisième article de nouvelles.', '2024-11-26 12:40:00');
CREATE DATABASE IF NOT EXISTS ormdatabase;

USE ormdatabase;

CREATE TABLE IF NOT EXISTS `news` (
    id VARCHAR(36) NOT NULL PRIMARY KEY,
    content VARCHAR(256) NOT NULL,
    created_at DATETIME NOT NULL        
);

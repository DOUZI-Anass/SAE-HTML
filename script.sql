CREATE DATABASE mon_site;
USE mon_site;

CREATE TABLE utilisateurs (
                              id INT AUTO_INCREMENT PRIMARY KEY,
                              nom VARCHAR(100),
                              email VARCHAR(100),
                              age INT
);


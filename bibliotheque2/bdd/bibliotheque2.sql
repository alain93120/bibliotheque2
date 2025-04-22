CREATE DATABASE IF NOT EXISTS bibliotheque CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE bibliotheque;

CREATE TABLE IF NOT EXISTS auteurs (
    id INT AUTO_INCREMENT PRIMARY KEY,  
    nom VARCHAR(100) NOT NULL,          
    prenom VARCHAR(100),                
    date_naissance DATE,                
    nationalite VARCHAR(100)            
);

INSERT INTO auteurs (nom, prenom, date_naissance, nationalite)
VALUES ('Camus', 'Albert', '1913-11-07', 'Française');

CREATE TABLE IF NOT EXISTS livres (
    id INT AUTO_INCREMENT PRIMARY KEY,  
    titre VARCHAR(255) NOT NULL,        
    genre VARCHAR(100),                 
    id_auteur INT,                      
    annee_publication INT,             
    FOREIGN KEY (id_auteur) REFERENCES auteurs(id) ON DELETE CASCADE
);
CREATE TABLE IF NOT EXISTS users (
    id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username varchar(100) NOT NULL,
    email varchar(100) NOT NULL,
    password varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO livres (titre, genre, id_auteur, annee_publication)
VALUES ('L\'Étranger', 'Philosophique', 1, 1942);

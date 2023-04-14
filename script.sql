CREATE DATABASE IF NOT EXISTS copiercare;

USE copiercare;

CREATE TABLE utilisateurs (
    id INT NOT NULL UNSIGNED AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    poste VARCHAR(150) NOT NULL,
    email VARCHAR(100) NOT NULL,
    rang VARCHAR(50) NOT NULL, /* USER | ADMIN */
    photo TEXT NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE clients (
    id INT NOT NULL UNSIGNED AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    tel INT NOT NULL,
    adresse VARCHAR(250),
    cp INT NOT NULL,
    ville VARCHAR(50),
    PRIMARY KEY (id)
);

CREATE TABLE multifonctions (
    id INT NOT NULL UNSIGNED AUTO_INCREMENT,
    marque VARCHAR(15) NOT NULL,
    modele VARCHAR(25) NOT NULL,
    date VARCHAR(10) NOT NULL,
    releve_compteur TEXT NOT NULL,
    client_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (client_id) REFERENCES clients(id)
);

CREATE TABLE pieces (
    id INT NOT NULL UNSIGNED AUTO_INCREMENT,
    marque VARCHAR(15) NOT NULL,
    modele VARCHAR(25) NOT NULL,
    reference VARCHAR(50),
    duree_de_vie VARCHAR(10) NOT NULL,
    PRIMARY KEY (id)
    date_modif
);
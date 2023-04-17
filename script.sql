CREATE DATABASE IF NOT EXISTS copiercare,

USE copiercare,

CREATE TABLE utilisateurs (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    rang VARCHAR(50) NOT NULL, /* USER | ADMIN ||||| ADMIN | TECH */
    photo TEXT NOT NULL,
    formation TEXT NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE clients (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nom_client VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    tel INT UNSIGNED NOT NULL,
    adresse VARCHAR(250) NOT NULL,
    interlocuteur VARCHAR(100) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE copieurs (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    marque VARCHAR(15) NOT NULL,
    modele VARCHAR(25) NOT NULL,
    date_mise_en_service VARCHAR(10) NOT NULL,
    dat_fin_garantie VARCHAR(10) NOT NULL,
    releve_compteur_nb TEXT NOT NULL,
    releve_compteur_couleur TEXT NOT NULL,
    client_id INT UNSIGNED NOT NULL,
    options TEXT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (client_id) REFERENCES clients(id)
);

CREATE TABLE conso (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    copieur_id INT UNSIGNED NOT NULL,
    tambour_noir INT UNSIGNED NOT NULL,
    tambour_couleur INT UNSIGNED NOT NULL,
    dev_noir INT UNSIGNED NOT NULL,
    dev_couleur INT UNSIGNED NOT NULL,
    courroie INT UNSIGNED NOT NULL,
    four INT UNSIGNED NOT NULL,
    patins_dep_papier INT UNSIGNED NOT NULL,
    patins_chargeur INT UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (copieur_id) REFERENCES copieurs(id)
);

CREATE TABLE pieces (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    PRIMARY KEY (id)
)
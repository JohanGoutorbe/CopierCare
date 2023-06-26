<?php

session_start();

// Connexion à la base de données locale
define('USER', "root");
define('PASSWD', '');
define('SERVER', "mysql-copiercare.alwaysdata.net");
define('BASE', "copiercareDB");

$dsn = "mysql:dbname=" . BASE . ";host=" . SERVER;

try {
    $db = new PDO($dsn, USER, PASSWD);
} catch (PDOException $e) {
    die('Erreur : ' . $e->getMessage() . "<br>");
}   

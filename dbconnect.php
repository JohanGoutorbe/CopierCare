<?php

session_start();

// Connexion à la base de données locale
define('USER', "root");
define('PASSWD', "");
define('SERVER', "localhost");
define('BASE', "copiercare");

$dsn = "mysql:dbname=" . BASE . ";host=" . SERVER;

try {
    $db = new PDO($dsn, USER, PASSWD);
} catch (PDOException $e) {
    die('Erreur : ' . $e->getMessage() . "<br>");
}   
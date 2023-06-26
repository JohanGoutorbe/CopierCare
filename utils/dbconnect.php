<?php

session_start();

// Connexion à la base de données locale
define('USER', "309818_root");
define('PASSWD', 'Pa$$w0rdAlwaysDataROOT');
define('SERVER', "mysql-copiercarev1.alwaysdata.net");
define('BASE', "copiercarev1_bdd");

$dsn = "mysql:dbname=" . BASE . ";host=" . SERVER;

try {
    $db = new PDO($dsn, USER, PASSWD);
} catch (PDOException $e) {
    die('Erreur : ' . $e->getMessage() . "<br>");
}   

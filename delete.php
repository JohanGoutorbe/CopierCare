<?php

//Affichage des erreurs sur la page web
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connexion à la base de données
include './dbconnect.php';

include './loggedVerif.php';

$table = trim(htmlspecialchars($_GET['table']));
$id = htmlspecialchars($_GET['id']);

$sql = "DELETE FROM `" . $table . "` WHERE `id` = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam('id', $id);
$stmt->execute();

$_SESSION['errors'] = "Une erreur est survenue lors la tentative de connexion.<br>Veuillez réessayer.";
$location = 'Location: ' . $table . '.php';
header($location);
exit();
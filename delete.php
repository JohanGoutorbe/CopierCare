<?php

//Affichage des erreurs sur la page web
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connexion à la base de données
include './dbconnect.php';

include './loggedVerif.php';

$error = '<p style="color: #ff7782;">L\'url est incorrecte</p>';

if (!isset($_GET['table'])) {
    $_SESSION['message'] = $error;
    exit();
} elseif (empty($_GET['table'])) {
    $_SESSION['message'] = $error;
    exit();
}
$location = 'Location: ' . $table . '.php';
if (!isset($_GET['id'])) {
    $_SESSION['message'] = $error;
    header($location);
    exit();
} elseif (empty($_GET['id'])) {
    $_SESSION['message'] = $error;
    header($location);
    exit();
}

$table = trim(htmlspecialchars($_GET['table']));
$id = htmlspecialchars($_GET['id']);

$sql = "DELETE FROM `" . $table . "` WHERE `id` = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam('id', $id);
$stmt->execute();

$_SESSION['errors'] = "Une erreur est survenue lors la tentative de connexion.<br>Veuillez réessayer";
$location = 'Location: ' . $table . '.php';
header($location);
exit();
<?php

//Affichage des erreurs sur la page web
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connexion à la base de données
include '../utils/dbconnect.php';

include '../utils/loggedVerif.php';

$error = '<p style="color: #ff7782;">L\'url est incorrecte</p>';

$location = 'Location: ./admin.php';
if (!isset($_GET['id'])) {
    $_SESSION['messageAdmin'] = $error;
    header($location);
    exit();
} elseif (empty($_GET['id'])) {
    $_SESSION['messageAdmin'] = $error;
    header($location);
    exit();
} elseif (!ctype_digit($_GET['id'])) {
    $_SESSION['messageAdmin'] = $error;
    header($location);
    exit();
}

if (!isset($_GET['prenom'])) {
    $_SESSION['messageAdmin'] = $error;
    header($location);
    exit();
} elseif (empty($_GET['prenom'])) {
    $_SESSION['messageAdmin'] = $error;
    header($location);
    exit();
} elseif (!ctype_alpha($_GET['prenom'])) {
    $_SESSION['messageAdmin'] = $error;
    header($location);
    exit();
}

if (!isset($_GET['nom'])) {
    $_SESSION['messageAdmin'] = $error;
    header($location);
    exit();
} elseif (empty($_GET['nom'])) {
    $_SESSION['messageAdmin'] = $error;
    header($location);
    exit();
} elseif (!ctype_alpha($_GET['nom'])) {
    $_SESSION['messageAdmin'] = $error;
    header($location);
    exit();
}

$id = htmlspecialchars($_GET['id']);
$prenom = htmlspecialchars($_GET['prenom']);
$nom = htmlspecialchars($_GET['nom']);

$sql = "DELETE FROM `utilisateurs` WHERE `id` = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam('id', $id);
$stmt->execute();

$_SESSION['messageAdmin'] = '<p style="color: #41f1b6; font-size: 1.25em; font-weight: 100;">La suppression de l\'utilisateur <strong>' . ucfirst($prenom) . ' ' . strtoupper($nom) . '</strong> s\'est bien effectuée</p>';
header($location);
exit();

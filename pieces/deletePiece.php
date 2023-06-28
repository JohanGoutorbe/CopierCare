<?php

error_reporting(0);

// Connexion à la base de données
include '../utils/dbconnect.php';

include '../utils/loggedVerif.php';

$error = '<p style="color: #ff7782;">L\'url est incorrecte</p>';

$location = 'Location: ./pieces.php';
if (!isset($_GET['id'])) {
    $_SESSION['message'] = $error;
    header($location);
    exit();
} elseif (empty($_GET['id'])) {
    $_SESSION['message'] = $error;
    header($location);
    exit();
} elseif (!ctype_digit($_GET['id'])) {
    $_SESSION['message'] = $error;
    header($location);
    exit();
}
if (!isset($_GET['name'])) {
    $_SESSION['message'] = $error;
    header($location);
    exit();
} elseif (empty($_GET['name'])) {
    $_SESSION['message'] = $error;
    header($location);
    exit();
}

$id = htmlspecialchars($_GET['id']);
$name = htmlspecialchars($_GET['name']);

$sql = "DELETE FROM `pieces` WHERE `id` = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam('id', $id);
$stmt->execute();

$type = "delete";
$action = "a supprimé la piece " . $name . ' de la liste des pieces';
include '../utils/log.php';

$_SESSION['message'] = '<p style="color: #41f1b6; font-size: 1.25em; font-weight: 100;">La suppression de la pièce <strong>' . $name . '</strong> s\'est bien effectuée</p>';
header($location);
exit();
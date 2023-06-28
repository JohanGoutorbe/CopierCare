<?php

error_reporting(0);

// Connexion à la base de données
include '../utils/dbconnect.php';

include '../utils/loggedVerif.php';

$error = '<p style="color: #ff7782;">L\'url est incorrecte</p>';

if (!isset($_GET['id'])) {
    $_SESSION['message'] = $error;
    header('Location: ./clients.php');
    exit();
} elseif (empty($_GET['id'])) {
    $_SESSION['message'] = $error;
    header('Location: ./clients.php');
    exit();
} elseif (!ctype_digit($_GET['id'])) {
    $_SESSION['message'] = $error;
    header('Location: ./clients.php');
    exit();
}
if (!isset($_GET['name'])) {
    $_SESSION['message'] = $error;
    header('Location: ./clients.php');
    exit();
} elseif (empty($_GET['name'])) {
    $_SESSION['message'] = $error;
    header('Location: ./clients.php');
    exit();
}

$id = htmlspecialchars($_GET['id']);
$name = htmlspecialchars($_GET['name']);

$sql = "DELETE FROM `clients` WHERE `id` = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam('id', $id);
$stmt->execute();

$type = "delete";
$action = "a supprimé le client " . $name . ' de la liste des cliens';
include '../utils/log.php';

$_SESSION['message'] = '<p style="color: #41f1b6; font-size: 1.25em; font-weight: 100;">La suppression du client <strong>' . $name . '</strong> s\'est bien effectué</p>';
header('Location: ./clients.php');
exit();
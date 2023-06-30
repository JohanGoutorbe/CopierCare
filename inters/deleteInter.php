<?php

error_reporting(0);

//Connexion à la base de données
include '../utils/dbconnect.php';

include '../utils/loggedVerif.php';

$error = '<p style="color: #ff7782;">L\'url est incorrecte</p>';

$location = 'Location: ./inter.php';
if (!isset($_GET['id'])) {
    $_SESSION['message'] = $error . "1";
    header($location);
    exit();
} elseif (empty($_GET['id'])) {
    $_SESSION['message'] = $error . "2";
    header($location);
    exit();
} elseif (!ctype_digit($_GET['id'])) {
    $_SESSION['message'] = $error . "3";
    header($location);
    exit();
}
if (!isset($_GET['inter'])) {
    $_SESSION['message'] = $error . "4";
    header($location);
    exit();
} elseif (empty($_GET['inter'])) {
    $_SESSION['message'] = $error . "5";
    header($location);
    exit();
}

$id = htmlspecialchars($_GET['id']);
$inter = htmlspecialchars($_GET['inter']);

$sql = "DELETE FROM `inter` WHERE `id` = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam('id', $id);
$stmt->execute();

$type = "delete";
$action = "a supprimé l'intervention " . $inter . ' de la liste des interventions';
include '../utils/log.php';

$_SESSION['message'] = '<p style="color: #41f1b6; font-size: 1.25em; font-weight: 100;">La suppression de l\'intervention <strong>' . $inter . '</strong> s\'est bien effectuée</p>';
header($location);
exit();
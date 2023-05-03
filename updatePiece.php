<?php

//Affichage des erreurs sur la page web
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connexion à la base de données
include './dbconnect.php';

include './loggedVerif.php';

$error = '<p style="color: #ff7782;">L\'url est incorrecte</p>';


$_SESSION['message'] = '<p style="color: #ff7782;">Erreur de modification de la pièce</p><br>';


if (!isset($_POST[('pieceUpdateSubmit')])) {
    $_SESSION['message'] .= '<p style="color: #ff7782;">L\'envoi du formulaire a échoué</p>';
    header('Location: piece.php');
    exit();
}

$id = htmlspecialchars($_POST['id']);
$name = htmlspecialchars($_POST['name']);
$ref = htmlspecialchars($_POST['ref']);

if (empty($id)) {
    $_SESSION['message'] .= '<p style="color: #ff7782;">L\'id est vide</p>';
    header('Location: pieces.php');
    exit();
} elseif (empty($_POST['name'])) {
    $_SESSION['message'] .= '<p style="color: #ff7782;">Le nom de la pièce est vide</p>';
    header('Location: pieces.php');
    exit();
} elseif (empty($_POST['ref'])) {
    $_SESSION['message'] .= '<p style="color: #ff7782;">La référence de la pièce est vide</p>';
    header('Location: pieces.php');
    exit();
}

if (!ctype_digit($id)) {
    $_SESSION['message'] .= '<p style="color: #ff7782;">L\'id de la pièce est incorrect</p>';
    header('Location: pieces.php');
    exit();
}

$intID = intval($id);

if (strlen($name) > 100) {
    $_SESSION['message'] .= '<p style="color: #ff7782;">Le nom de la pièce excède 100 caractères</p>';
    header('Location: pieces.php');
    exit();
} elseif (strlen($ref) > 20) {
    $_SESSION['message'] .= '<p style="color: #ff7782;">La référence de la pièce excède 20 caractères</p>';
    header('Location: pieces.php');
    exit();
} elseif (strlen($name) < strlen($ref)) {
    $_SESSION['message'] .= '<p style="color: #ff7782;">La référence de la pièce doit être plus courte que son nom</p>';
    header('Location: pieces.php');
    exit();
}

$sql = "UPDATE `pieces` SET `nom` = :name, `ref` = :ref WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam('name', $name);
$stmt->bindParam('ref', $ref);
$stmt->bindParam('id', $intID);
$stmt->execute();
$_SESSION['message'] = '<p style="color: #41f1b6; text-shadow: 0px 0px black;">La pièce <strong>' . $name . '</strong> a bien été modifiée.</p>';
header('Location: pieces.php');
exit();
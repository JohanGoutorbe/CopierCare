<?php

error_reporting(0);

// Connexion à la base de données
include '../utils/dbconnect.php';

include '../utils/loggedVerif.php';

$error = '<p style="color: #ff7782;">L\'url est incorrecte</p>';

if (!isset($_POST[('pieceUpdateSubmit')])) {
    $_SESSION['message'] .= '<p style="color: #ff7782;">L\'envoi du formulaire a échoué</p>';
    header('Location: ./piece.php');
    exit();
}

$id = htmlspecialchars($_POST['id']);
$name = htmlspecialchars($_POST['name']);
$ref = htmlspecialchars($_POST['ref']);

if (empty($id)) {
    $_SESSION['message'] .= '<p style="color: #ff7782;">L\'id est vide</p>';
    header('Location: ./pieces.php');
    exit();
} elseif (empty($_POST['name'])) {
    $_SESSION['message'] .= '<p style="color: #ff7782;">Le nom de la pièce est vide</p>';
    header('Location: ./pieces.php');
    exit();
} elseif (empty($_POST['ref'])) {
    $_SESSION['message'] .= '<p style="color: #ff7782;">La référence de la pièce est vide</p>';
    header('Location: ./pieces.php');
    exit();
}

if (!ctype_digit($id)) {
    $_SESSION['message'] .= '<p style="color: #ff7782;">L\'id de la pièce est incorrect</p>';
    header('Location: ./pieces.php');
    exit();
}

if (strlen($name) > 100) {
    $_SESSION['message'] .= '<p style="color: #ff7782;">Le nom de la pièce excède 100 caractères</p>';
    header('Location: ./pieces.php');
    exit();
} elseif (strlen($ref) > 20) {
    $_SESSION['message'] .= '<p style="color: #ff7782;">La référence de la pièce excède 20 caractères</p>';
    header('Location: ./pieces.php');
    exit();
} elseif (strlen($name) < strlen($ref)) {
    $_SESSION['message'] .= '<p style="color: #ff7782;">La référence de la pièce doit être plus courte que son nom</p>';
    header('Location: ./pieces.php');
    exit();
}

$sql = "UPDATE `pieces` SET `nom` = :name, `ref` = :ref WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam('name', $name);
$stmt->bindParam('ref', $ref);
$stmt->bindParam('id', $id);
$stmt->execute();

$type = "update";
$action = "a modifié la piece " . $name . ' dans la liste des pieces';
include '../utils/log.php';

$_SESSION['message'] = '<p style="color: #41f1b6; text-shadow: 0px 0px black; font-size: 1.25em; font-weight: 100;">La pièce <strong>' . $name . '</strong> a bien été modifiée.</p>';
header('Location: ./pieces.php');
exit();
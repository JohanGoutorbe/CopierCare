<?php

//Affichage des erreurs sur la page web
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connexion à la base de données
include '../utils/dbconnect.php';

include '../utils/loggedVerif.php';

$error = '<p style="color: #ff7782;">L\'url est incorrecte</p>';

if (!isset($_POST[('clientUpdateSubmit')])) {
    $_SESSION['message'] .= '<p style="color: #ff7782;">L\'envoi du formulaire a échoué</p>';
    header('Location: ./clients.php');
    exit();
}

$id = htmlspecialchars($_POST['id']);
$name = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['email']);
$tel = str_replace(' ', '', htmlspecialchars($_POST['tel']));
$adresse = htmlspecialchars($_POST['adresse']);
$interlocuteur = htmlspecialchars($_POST['interlocuteur']);

if (empty($id)) {
    $_SESSION['message'] .= '<p style="color: #ff7782;">L\'id du client est vide</p>';
    header('Location: ./clients.php');
    exit();
} elseif (empty($_POST['name'])) {
    $_SESSION['message'] .= '<p style="color: #ff7782;">Le nom du client est vide</p>';
    header('Location: ./clients.php');
    exit();
} elseif (empty($_POST['email'])) {
    $_SESSION['message'] .= '<p style="color: #ff7782;">L\'adresse email du client est vide</p>';
    header('Location: ./clients.php');
    exit();
} elseif (empty($_POST['tel'])) {
    $_SESSION['message'] .= '<p style="color: #ff7782;">Le numéro de téléphone du client est vide</p>';
    header('Location: ./clients.php');
    exit();
} elseif (empty($_POST['adresse'])) {
    $_SESSION['message'] .= '<p style="color: #ff7782;">L\' adresse du client est vide</p>';
    header('Location: ./clients.php');
    exit();
} elseif (empty($_POST['interlocuteur'])) {
    $_SESSION['message'] .= '<p style="color: #ff7782;">L\'interlocuteur est vide</p>';
    header('Location: ./clients.php');
    exit();
}
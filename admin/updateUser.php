<?php

//Affichage des erreurs sur la page web
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connexion à la base de données
include '../utils/dbconnect.php';

include '../utils/loggedVerif.php';

$error = '<p style="color: #ff7782;">L\'url est incorrecte</p>';


$_SESSION['message'] = '<p style="color: #ff7782;">Erreur de modification de l\'utilisateur</p><br>';


if (!isset($_POST[('userUpdateSubmit')])) {
    $_SESSION['message'] .= '<p style="color: #ff7782;">L\'envoi du formulaire a échoué</p>';
    header('Location: ./admin.php');
    exit();
}

$id = htmlspecialchars($_POST['id']);
$nom = htmlspecialchars($_POST['nom']);
$prenom = htmlspecialchars($_POST['prenom']);
$email = htmlspecialchars($_POST['email']);
$rang = htmlspecialchars($_POST['rang']);
$formation = htmlspecialchars($_POST['formation']);

if (empty($id)) {
    $_SESSION['message'] .= '<p style="color: #ff7782;">L\'id est vide</p>';
    header('Location: ./admin.php');
    exit();
} elseif (empty($nom)) {
    $_SESSION['message'] .= '<p style="color: #ff7782;">Le nom de l\'utilisateur est vide</p>';
    header('Location: ./admin.php');
    exit();
} elseif (empty($prenom)) {
    $_SESSION['message'] .= '<p style="color: #ff7782;">La référence de l\'utilisateur est vide</p>';
    header('Location: ./admin.php');
    exit();
} elseif (empty($email)) {
    $_SESSION['message'] .= '<p style="color: #ff7782;">L\'email de l\'utilisateur est vide</p>';
    header('Location: ./admin.php');
    exit();
} elseif (empty($rang)) {
    $_SESSION['message'] .= '<p style="color: #ff7782;">Le rang de l\'utilisateur est vide</p>';
    header('Location: ./admin.php');
    exit();
}

if (!ctype_digit($id)) {
    $_SESSION['message'] .= '<p style="color: #ff7782;">L\'id de l\'utilisateur est incorrect</p>';
    header('Location: ./admin.php');
    exit();
}

if (strlen($nom) > 50) {
    $_SESSION['message'] .= '<p style="color: #ff7782;">Le nom de l\'utilisateur excède 50 caractères</p>';
    header('Location: ./admin.php');
    exit();
} elseif (strlen($prenom) > 50) {
    $_SESSION['message'] .= '<p style="color: #ff7782;">Le prénom de l\'utilisateur excède 50 caractères</p>';
    header('Location: ./admin.php');
    exit();
} elseif (strlen($email) > 100) {
    $_SESSION['message'] .= '<p style="color: #ff7782;">L\'email de l\'utilisateur excède 50 caractères</p>';
    header('Location: ./admin.php');
    exit();
} elseif (strlen($rang) > 50) {
    $_SESSION['message'] .= '<p style="color: #ff7782;">Le rang de l\'utilisateur excède 50 caractères</p>';
    header('Location: ./admin.php');
    exit();
} 

if (filter_var($email, FILTER_VALIDATE_EMAIL) !== true) {
    $_SESSION['message'] .= '<p style="color: #ff7782;">L\'email de l\'utilisateur est incorrect</p>';
    header('Location: ./admin.php');
    exit();
}

$sql = "UPDATE `utilisateurs` SET `nom` = :nom, `prenom` = :prenom, `email` = :email, `rang` = :rang, `formation` = :formation WHERE `id` = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam('nom', $nom);
$stmt->bindParam('prenom', $prenom);
$stmt->bindParam('email', $email);
$stmt->bindParam('rang', $rang);
$stmt->bindParam('formation', $formation);
$stmt->bindParam('id', $id);
$stmt->execute();
$_SESSION['message'] = '<p style="color: #41f1b6; text-shadow: 0px 0px black; font-size: 1.25em; font-weight: 100;">L\'utilisateur <strong>' . ucfirst($prenom) . ' ' . strtoupper($nom) . '</strong> a bien été modifié.</p>';
header('Location: ./admin.php');
exit();
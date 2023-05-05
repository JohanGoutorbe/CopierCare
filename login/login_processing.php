<?php

// Affichage des erreurs
ini_set('display_errors', 1);
ini_set('displau_startup_errors', 1);
error_reporting(E_ALL);

// Connexion à la base de données
include '../utils/dbconnect.php';

// Déclaration des variables
$username_validate = false;
$email_validate = false;
$_SESSION['logged'] = false;
$_SESSION['errors'] = "";

if (isset($_POST['username']) && isset($_POST['pwd1'])) {
    $username = str_replace(' ', '', $_POST['username']);
    $pwd = str_replace(' ', '', $_POST['pwd1']);
    if (empty($username) && empty($pwd1) || empty($username) || empty($pwd)) {
        $_SESSION['errors'] = "L'identifiant et/ou le mot de passe est vide";
        header('Location: login.php');
        exit();
    } elseif (strlen($username) > 30) {
        $_SESSION['errors'] = "L'identifiant de connexion est incorrect";
        header('Location: login.php');
        exit();
    } elseif (!ctype_alpha($username)) {
        $_SESSION['errors'] = "L'identifiant de connexion est incorrect";
        header('Location: login.php');
        exit();
    } elseif (strlen($pwd) > 20) {
        $_SESSION['errors'] = "Le mot de passe est incorrect";
        header('Location: login.php');
        exit();
    } else {
        $username_validate = true;
    }
} 

if ($username_validate) {
    $sql = "SELECT * FROM `utilisateurs` WHERE `identifiant` = :username AND mdp = :pwd";
    $stmt = $db->prepare($sql);
    $stmt->execute(
        array(
            'username' => $username,
            'pwd' => $pwd
        )
    );
    $count = $stmt->rowCount();
    if ($count > 0) {
        $_SESSION['logged'] = true;
        $_SESSION['username'] = $username;
        header('Location: ../index.php');
        exit();
    } elseif ($count < 1) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result['identifiant'] !== $username) {
            $_SESSION['errors'] = "L'identifiant de connexion est incorrect";
            header('Location: login.php');
            exit();
        } elseif ($result['mdp'] !== $pwd) {
            $_SESSION['errors'] = "Le mot de passe est incorrect";
            header('Location: login.php');
            exit();
        } else {
            $_SESSION['errors'] = "il n'existe aucun utilisateur enregistré à ce nom";
            header('Location: login.php');
        }
    }
}

$_SESSION['errors'] = "Une erreur est survenue lors la tentative de connexion.<br>Veuillez réessayer.";
header('Location: login.php');
exit();
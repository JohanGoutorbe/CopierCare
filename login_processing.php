<?php

// Affichage des erreurs
ini_set('display_errors', 1);
ini_set('displau_startup_errors', 1);
error_reporting(E_ALL);

// Connexion à la base de données
include './dbconnect.php';

if (isset($_POST['username']) && isset($_POST['pwd'])) {
    if (!empty($_POST['username']) && !empty($_POST['pwd'])) {
        $username = htmlspecialchars($_POST['username']);
        $pwd = htmlspecialchars($_POST['pwd']);
        if (strlen($username) < 30) {
            if (ctype_alpha($username)) {
                if (strlen($pwd) < 20) {
                    # code...
                } else {
                    $_SESSION['errors'] = "Le mot de passe est incorrect";
                    header('Location: login.php');
                }
            } else {
                $_SESSION['errors'] = "L'identifiant de connexion est incorrect";
                header('Location: login.php');
            }
        } else {
            $_SESSION['errors'] = "L'identifiant de connexion est incorrect";
            header('Location: login.php');
        }
    } else {
        $_SESSION['errors'] = "L'identifiant de connexion ou le mot de passe est vide";
        header('Location: login.php');
    }
} elseif (isset($_POST['email']) && isset($_POST['pwd'])) {
    if (!empty($_POST['email']) && !empty($_POST['pwd'])) {
        $email = htmlspecialchars($_POST['email']);
        $pwd = htmlspecialchars($_POST['pwd']);
    } else {
        $_SESSION['errors'] = "L'adresse mail ou le mot de passe est vide";
        header('Location: login.php');
    }
} else {
    $_SESSION['errors'] = "Veuillez vous connecter avec l'une des méthodes proposées ci-dessus.";
    header('Location: login.php');
}
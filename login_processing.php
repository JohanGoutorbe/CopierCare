<?php

// Affichage des erreurs
ini_set('display_errors', 1);
ini_set('displau_startup_errors', 1);
error_reporting(E_ALL);

// Connexion à la base de données
include './dbconnect.php';

// Déclaration des variables
$username_validate = false;
$email_validate = false;
$_SESSION['logged'] = false;
$_SESSION['errors'] = "";

if (!isset($_POST['username']) && !isset($_POST['pwd'])) {
    $username = $_POST['username'];
    $pwd = htmlspecialchars($_POST['pwd']);
} else {
    $_SESSION['errors'] = "L'identifiant de connexion ou le mot de passe est vide";
    header('Location: login.php');
}

if (!isset($_POST['username']) && !isset($_POST['pwd']) && !isset($_POST['email']) && !isset($_POST['pwd'])) {
    $_SESSION['errors'] = "Veuillez vous connecter avec l'une des méthodes proposées ci-dessus.";
    header('Location: login.php');
} elseif (!empty($_POST['username']) && !empty($_POST['pwd']) && !empty($_POST['email']) && !empty($_POST['pwd'])) {
    $_SESSION['errors'] = "Veuillez vous connecter avec l'une des méthodes proposées ci-dessus.";
    header('Location: login.php');
}

if (isset($_POST['username']) && isset($_POST['pwd'])) {
    $username = $_POST['username'];
    $pwd = $_POST['pwd'];
    if (empty($username) && empty($pwd) || empty($username) || empty($pwd)) {
        $_SESSION['errors'] = "L'identifiant ou le mot de passe est vide";
        header('Location: login.php');
    } elseif (strlen($username) > 30) {
        $_SESSION['errors'] = "L'identifiant de connexion est incorrect";
        header('Location: login.php');
    } elseif (!ctype_alpha($username)) {
        $_SESSION['errors'] = "L'identifiant de connexion est incorrect";
        header('Location: login.php');
    } elseif (strlen($pwd) > 20) {
        $_SESSION['errors'] = "Le mot de passe est incorrect";
        header('Location: login.php');
    } else {
        $username_validate = true;
    }
} elseif (isset($_POST['email']) && isset($_POST['pwd'])) {
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];
    if (empty($email) && empty($pwd) || empty($email) || empty($pwd)) {
        $_SESSION['errors'] = "L'adresse mail ou le mot de passe est vide";
        header('Location: login.php');
    } elseif (strlen($email) > 100) {
        $_SESSION['errors'] = "L'adresse mail est incorrecte";
        header('Location: login.php');
    }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['errors'] = "L'adresse mail est incorrecte";
        header('Location: login.php');
    } elseif (!ctype_alpha($email)) {
        $_SESSION['errors'] = "L'adresse mail est incorrecte";
        header('Location: login.php');
    } elseif (strlen($pwd) > 20) {
        $_SESSION['errors'] = "Le mot de passe est incorrect";
        header('Location: login.php');
    } else {
        $email_validate = true;
    }
}


if ($username_validate) {
    $sql = "SELECT * FROM `utilisateurs` WHERE `identifiant` = :username AND mdp = :pwd";
    $stmt = $db->prepare($sql);
    $stmt->bindParam('username', $username);
    $stmt->bindParam('pwd', $pwd);
    $stmt->execute();
    $userCount = $stmt->rowCount();
    if ($userCount == 1) {
        $_SESSION['logged'] = true;
        $_SESSION['username'] = $username;
    } else {
        # code...
    }
    
    
} elseif ($email_validate) {
    # code...
}


$_SESSION['errors'] = "Les identifiants renseignés n'ont pas permis de vous authentifier.<br>Veuillez réessayer.";
header('Location: login.php');
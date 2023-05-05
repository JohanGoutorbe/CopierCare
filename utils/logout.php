<?php

// Réinitialisation des variables de session
$_SESSION['validate'] = false;
$_SESSION['logged'] = false;
$_SESSION['username'] = "";
$_SESSION['surname'] = "";
$_SESSION['photo'] = "";
$_SESSION['rang'] = "";

// Suppression totale des variables de sessions
session_unset();

// Fermeture complète de la session
session_destroy();

// Redirection vers le formulaire de connexion
header('location: login.php');

exit;
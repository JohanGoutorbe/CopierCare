<?php

//Affichage des erreurs sur la page web
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CopierCare | Connexion</title>
    <link rel="stylesheet" href="./style/login_style.css">
    <link rel="shortcut icon" href="./files/logo_copiercare.png" type="image/x-icon">
</head>

<body>
    <section>
        <form action="./login_processing.php" method="post">
            <h1>Se connecter</h1>
            <p class="choose-email">En utilisant un nom d'utilisateur :</p>
            <div class="inputs">
                <input type="text" placeholder="Nom d'utiliateur">
                <input type="password" placeholder="Mot de passe">
                <button type="submit">Se connecter</button>
            </div>
        </form>
        <form action="./login_processing.php" method="post">
            <p class="choose-email">En utilisant un nom d'utilisateur :</p>
            <div class="inputs">
                <input type="text" placeholder="Nom d'utiliateur">
                <input type="password" placeholder="Mot de passe">
                <button type="submit">Se connecter</button>
            </div>
        </form>
    </section>
</body>
</html>
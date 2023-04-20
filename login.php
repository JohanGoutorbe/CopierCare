<?php

// Affichage des erreurs
ini_set('display_errors', 1);
ini_set('displau_startup_errors', 1);
error_reporting(E_ALL);

// Initialisation de la session
session_start();

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
        <form action="./login_processing.php" method="post" class="form1">
            <h1>Se connecter</h1>
            <p class="choose-email">En utilisant un <strong>nom d'utilisateur</strong> :</p>
            <div class="inputs">
                <input name="username" type="text" placeholder="Nom d'utiliateur">
                <input name="pwd1" type="password" placeholder="Mot de passe">
                <button type="submit">Se connecter</button>
            </div>
            <?php if (isset($_SESSION['errors'])) { 
                echo '<br><br><p class="error" style="max-width: 300px; color: red; font-family: \'Roboto\', sans-serif; text-align: center; margin-top: 0;">' . $_SESSION['errors'] . '</p>';
            } ?>
        </form>
    </section>
</body>

</html>
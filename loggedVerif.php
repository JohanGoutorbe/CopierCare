<?php

if (isset($_SESSION['logged']) && $_SESSION['logged'] == true && !empty($_SESSION['username'])) {
    $_SESSION['validate'] = true;
} else {
    $_SESSION['errors'] = "Veuillez vous authentifier à l'aide de l'une des méthodes ci-dessus.";
    header('Location: login.php');
    exit();
}
<?php

//Affichage des erreurs sur la page web
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include './dbconnect.php';
/*

<!-- Lire et écrire les relevés compteurs dans la base de données -->

$query  = "SELECT * FROM `test`";
$stmt = $db->prepare($query);
$stmt->execute();

$iterations_number = 3;
$longueur_releve_compteur = 7;

while ($query = $stmt->fetch()) {
    $i = 0;
    $values = -9;
    while ($i < $iterations_number) {
        $i++;
        $actual_values = $values * $i;
        $num = substr($query['test'], $actual_values, $longueur_releve_compteur);
        echo $num . "; ";
    }
    echo "</br>";
}
*/

include './head.php';

include './accueil.php'
?>
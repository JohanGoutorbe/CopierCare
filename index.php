<?php

//Affichage des erreurs sur la page web
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include './dbconnect.php';

$query  = "SELECT * FROM `test`";
$stmt = $db->prepare($query);
$stmt->execute();

$iterations_number = 3;
$longueur_releve_compteur = 7;

while ($query = $stmt->fetch()) {
    $i = 1;
    $values = -9;
    while ($i-1 < $iterations_number) {
        $actual_values = $values * $i;
        $num = substr($query['test'], $actual_values, $longueur_releve_compteur);
        $i++;
        echo $num . "; ";
    }
    echo "</br>";
}


?>
<?php

//Affichage des erreurs sur la page web
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include './dbconnect.php';

$query  = "SELECT * FROM `test`";
$stmt = $db->prepare($query);
$stmt->execute();
while ($query = $stmt->fetch()) {
    echo $query['test'] . "</br>";
}


?>
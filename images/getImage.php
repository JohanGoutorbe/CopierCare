<?php
include '../utils/dbconnect.php';
include '../utils/loggedVerif.php';
$req=$db->prepare("select * from images where nom=? limit 1");
$req->setFetchMode(PDO::FETCH_ASSOC);
$req->execute(array($_GET["nom"]));
$tab=$req->fetchAll();
echo $tab[0]["bin"];
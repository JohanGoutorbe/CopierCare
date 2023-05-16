<?php

error_reporting(0);

include '../utils/loggedVerif.php';

if (isset($_POST["valider"])) {
    include '../utils/dbconnect.php';
    $req=$db->prepare("insert into images(nom,taille,bin) values(?,?,?)");
    $req->execute(array($_FILES["image"]["name"],$_FILES["image"]["size"],file_get_contents($_FILES["image"]["tmp_name"])));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>
    <form name="foo" action="" method="post" enctype="multipart/form-data">
        <input type="file" name="image"><br>
        <input type="submit" name="valider" value="Charger">
    </form>
</body>
</html>
<?php

error_reporting(0);

// Connexion à la base de données
include '../utils/dbconnect.php';

include '../utils/loggedVerif.php';

$error = '<p style="color: #ff7782;">L\'url est incorrecte</p>';

$location = 'Location: ./pieces.php';
if (!isset($_GET['id'])) {
    $_SESSION['message'] = $error;
    header($location);
    exit();
} elseif (empty($_GET['id'])) {
    $_SESSION['message'] = $error;
    header($location);
    exit();
} elseif (!ctype_digit($_GET['id'])) {
    $_SESSION['message'] = $error;
    header($location);
    exit();
}
if (!isset($_GET['name'])) {
    $_SESSION['message'] = $error;
    header($location);
    exit();
} elseif (empty($_GET['name'])) {
    $_SESSION['message'] = $error;
    header($location);
    exit();
}

$id = htmlspecialchars($_GET['id']);
$name = htmlspecialchars($_GET['name']);

$sql = "DELETE FROM `pieces` WHERE `id` = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam('id', $id);
$stmt->execute();

$file = '../json/logs.json';
$content = file_get_contents($file);
$data = json_decode($content, true);
$maxIndex = 0;
foreach ($data as $item) {
    $index = intval($item['index']);
    if ($index > $maxIndex) {
        $maxIndex = $index;
    }
}
$newIndex = $maxIndex + 1;

$result = $stmt->fetch(PDO::FETCH_ASSOC);

$getdt = new \DateTime();
$dt = $getdt->format('Y-m-d H:i:s');

$newObject = [
    "logID" => strval($newIndex),
    "type" => "delete",
    "userID" => $_SESSION['id'],
    "name" => $_SESSION['name'],
    "surname" => $_SESSION['surname'],
    "role" => $_SESSION['rang'],
    "date" => $dt,
    "action" => "a supprimé la piece " . $name . ' de la liste des pieces'
];

array_unshift($data, $newObject);
$json = json_encode($data, JSON_PRETTY_PRINT);
file_put_contents($file, $json);

$_SESSION['message'] = '<p style="color: #41f1b6; font-size: 1.25em; font-weight: 100;">La suppression de la pièce <strong>' . $name . '</strong> s\'est bien effectuée</p>';
header($location);
exit();
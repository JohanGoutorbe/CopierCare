<?php

error_reporting(0);

// Connexion à la base de données
include '../utils/dbconnect.php';

include '../utils/loggedVerif.php';

$_SESSION['clientMessage'] = "Erreur de modification du client<br>";
$error = '<p style="color: #ff7782;">L\'url est incorrecte</p>';

if (!isset($_POST[('clientUpdateSubmit')])) {
    $_SESSION['clientMessage'] .= '<p style="color: #ff7782;">L\'envoi du formulaire a échoué</p>';
    header('Location: ./clients.php');
    exit();
}

$id = htmlspecialchars($_POST['id']);
$name = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['email']);
$tel = str_replace(' ', '', htmlspecialchars($_POST['tel']));
$adresse = htmlspecialchars($_POST['adresse']);
$interlocuteur = htmlspecialchars($_POST['interlocuteur']);

if (empty($id)) {
    $_SESSION['clientMessage'] .= '<p style="color: #ff7782;">L\'id du client est vide</p>';
    header('Location: ./clients.php');
    exit();
} elseif (empty($name)) {
    $_SESSION['clientMessage'] .= '<p style="color: #ff7782;">Le nom du client est vide</p>';
    header('Location: ./clients.php');
    exit();
} elseif (empty($email)) {
    $_SESSION['clientMessage'] .= '<p style="color: #ff7782;">L\'adresse email du client est vide</p>';
    header('Location: ./clients.php');
    exit();
} elseif (empty($tel)) {
    $_SESSION['clientMessage'] .= '<p style="color: #ff7782;">Le numéro de téléphone du client est vide</p>';
    header('Location: ./clients.php');
    exit();
} elseif (empty($adresse)) {
    $_SESSION['clientMessage'] .= '<p style="color: #ff7782;">L\' adresse du client est vide</p>';
    header('Location: ./clients.php');
    exit();
} elseif (empty($interlocuteur)) {
    $_SESSION['clientMessage'] .= '<p style="color: #ff7782;">L\'interlocuteur est vide</p>';
    header('Location: ./clients.php');
    exit();
}

if (!ctype_digit($id)) {
    $_SESSION['clientMessage'] .= '<p style="color: #ff7782;">L\'id du client est incorrect</p>';
    header('Location: ./clients.php');
    exit();
} elseif (!ctype_digit($tel)) {
    $_SESSION['clientMessage'] .= '<p style="color: #ff7782;">Le numéro de téléphone du client est incorrect</p>';
    header('Location: ./clients.php');
    exit();
}

if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
    $_SESSION['clientMessage'] .= '<p style="color: #ff7782;">L\'adresse mail du client est incorrecte</p>';
    header('Location: ./clients.php');
    exit();
}

if (strlen($name) > 100) {
    $_SESSION['clientMessage'] .= '<p style="color: #ff7782;">Le nom du client est incorrect</p>';
    header('Location: ./clients.php');
    exit();
} elseif (strlen($email) > 100) {
    $_SESSION['clientMessage'] .= '<p style="color: #ff7782;">L\'adresse mail du client est incorrecte</p>';
    header('Location: ./clients.php');
    exit();
} elseif (strlen($tel) > 10) {
    $_SESSION['clientMessage'] .= '<p style="color: #ff7782;">Le numéro de téléphone du client est incorrect</p>';
    header('Location: ./clients.php');
    exit();
} elseif (strlen($adresse) > 250) {
    $_SESSION['clientMessage'] .= '<p style="color: #ff7782;">L\'adresse du client est incorrecte</p>';
    header('Location: ./clients.php');
    exit();
} elseif (strlen($interlocuteur) > 100) {
    $_SESSION['clientMessage'] .= '<p style="color: #ff7782;">L\'interlocuteur est incorrect</p>';
    header('Location: ./clients.php');
    exit();
}

$sql = "UPDATE `clients` SET `nom_client` = :name, `email` = :email, `tel` = :tel, `adresse` = :adresse, `interlocuteur` = :interlocuteur WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam('name', $name);
$stmt->bindParam('email', $email);
$stmt->bindParam('tel', $tel);
$stmt->bindParam('adresse', $adresse);
$stmt->bindParam('interlocuteur', $interlocuteur);
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
    "type" => "update",
    "userID" => $_SESSION['id'],
    "name" => $_SESSION['name'],
    "surname" => $_SESSION['surname'],
    "role" => $_SESSION['rang'],
    "date" => $dt,
    "action" => "a modifié le client " . $name . ' dans la liste des clients'
];

array_unshift($data, $newObject);
$json = json_encode($data, JSON_PRETTY_PRINT);
file_put_contents($file, $json);

$_SESSION['clientMessage'] = '<p style="color: #41f1b6; text-shadow: 0px 0px black; font-size: 1.25em; font-weight: 100;">Le client <strong>' . $name . '</strong> a bien été modifiée.</p>';
header('Location: ./clients.php');
exit();
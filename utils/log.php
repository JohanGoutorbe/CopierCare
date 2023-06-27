<?php

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
    "type" => "create",
    "userID" => $_SESSION['id'],
    "name" => $_SESSION['name'],
    "role" => $_SESSION['rang'],
    "date" => $dt,
    "action" => "a ajouté le client " . $name . ' à la liste des clients'
];

array_unshift(
    $data,
    $newObject
);
$json = json_encode($data, JSON_PRETTY_PRINT);
file_put_contents($file, $json);
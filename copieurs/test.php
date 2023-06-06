<?php
$totalLignes = 25;
$lignesAffichees = 10;

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'voir_tout') {
        $lignesAffichees = $totalLignes;
    } elseif ($_POST['action'] == 'voir_moins') {
        $lignesAffichees = 10;
    }
}

$tableau = '';
for ($i = 1; $i <= $lignesAffichees; $i++) {
    $tableau .= "<tr><td>Ligne $i</td></tr>";
}

echo '<table>';
echo $tableau;
echo '</table>';

if ($lignesAffichees == $totalLignes) {
    echo '<form action="" method="POST">
            <input type="hidden" name="action" value="voir_moins">
            <input type="submit" value="Voir moins">
          </form>';
} else {
    echo '<form action="" method="POST">
            <input type="hidden" name="action" value="voir_tout">
            <input type="submit" value="Voir tout">
          </form>';
}
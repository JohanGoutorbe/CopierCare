<?php

error_reporting(0);

// Connexion à la base de données
include './utils/dbconnect.php';

if (isset($_SESSION['logged']) && $_SESSION['logged'] == true && !empty($_SESSION['username'])) {
    $_SESSION['validate'] = true;
} else {
    $_SESSION['errors'] = "Veuillez vous authentifier à l'aide de l'une des méthodes ci-dessus.";
    header('Location: ./login/login.php');
    exit();
}

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
}*/

$_SESSION['message'] = '';
$_SESSION['messageAdmin'] = '';
$username = $_SESSION['username'];

$sql = "SELECT * FROM `utilisateurs` WHERE `identifiant` = :username";
$stmt = $db->prepare($sql);
$stmt->bindParam('username', $username);
$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);
$_SESSION['surname'] = $result['prenom'];
$_SESSION['name'] = $result['nom'];
$_SESSION['photo'] = $result['photo'];
$_SESSION['rang'] = $result['rang'];
$_SESSION['id'] = $result['id'];

$sql = 'SELECT * FROM `copieurs`';
$stmt = $db->prepare($sql);
$stmt->execute();
$copieursCount = $stmt->rowCount();

$sql = 'SELECT * FROM `clients`';
$stmt = $db->prepare($sql);
$stmt->execute();
$clientsCount = $stmt->rowCount();

$sql = 'SELECT * FROM `inters`';
$stmt = $db->prepare($sql);
$stmt->execute();
$intersCount = $stmt->rowCount();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CopierCare - Tableau de bord
    </title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+outlined">
    <link rel="stylesheet" href="./style/style.css">
    <link rel="shortcut icon" href="./images/getImage.php?nom=logo_copiercare.png" type="image/x-icon">
</head>

<body>
    <div class="container">
        <aside>
            <div class="top">
                <div class="logo">
                    <img src="./images/getImage.php?nom=logo_copiercare.png" alt="CopierCare logo">
                    <h2><span class="danger">COPIER</span>CARE</h2>
                </div>
                <div class="close" id="close-btn">
                    <span class="material-icons-sharp">close</span>
                </div>
            </div>

            <div class="sidebar">
                <a href="" class="active">
                    <span class="material-icons-sharp">home</span>
                    <h3>Accueil</h3>
                </a>
                <a href="./alertes/alertes.php">
                    <span class="material-icons-sharp">report_gmailerrorred</span>
                    <h3>Alertes</h3>
                </a>
                <a href="./inters/inter.php">
                    <span class="material-icons-sharp">description</span>
                    <h3>Interventions</h3>
                </a>
                <a href="./clients/clients.php">
                    <span class="material-icons-sharp">groups</span>
                    <h3>Clients</h3>
                </a>
                <a href="./copieurs/copieurs.php">
                    <span style="width: 24px;" class="material-icons-sharp">print_outline</span>
                    <h3>Copieurs</h3>
                </a>
                <a href="./consommables/consommables.php">
                    <span class="material-icons-sharp">construction</span>
                    <h3>Consommables</h3>
                </a>
                <a href="./pieces/pieces.php">
                    <span class="material-icons-sharp">devices</span>
                    <h3>Pièces</h3>
                </a>
                <a href="./parametres/parametres.php">
                    <span class="material-icons-sharp">settings</span>
                    <h3>Paramètres</h3>
                </a>
                <a href="./admin/admin.php" <?php if ($_SESSION['rang'] !== 'admin') {
                                                echo ' style="display:none;"';
                                            } ?>>
                    <span class="material-icons-sharp">admin_panel_settings</span>
                    <h3>Administrateur</h3>
                </a>
                <a href="./utils/logout.php">
                    <span class="material-icons-sharp">logout</span>
                    <h3>Se déconnecter</h3>
                </a>
            </div>
        </aside>
        <!----------------------- END OF ASIDE ------------------------->

        <main>
            <h1>Tableau de bord</h1>

            <div class="date">
                <input type="date">
            </div>

            <div class="insights">
                <div class="sales">
                    <span class="material-icons-sharp">analytics</span>
                    <div class="middle">
                        <div class="left">
                            <h3>Nombre de copieurs</h3>
                            <h1><?php echo $copieursCount; ?></h1>
                        </div>
                        <div class="progress">
                            <svg>
                                <circle cx='38' cy='38' r='36'></circle>
                            </svg>
                            <div class="number">
                                <p>81%</p>
                            </div>
                        </div>
                    </div>
                    <small class="text-muted">Depuis le 21 avril 2023</small>
                </div>
                <!--------------- END OF SALES ------------>
                <div class="expenses">
                    <span class="material-icons-sharp">bar_chart</span>
                    <div class="middle">
                        <div class="left">
                            <h3>Nombre d'interventions</h3>
                            <h1><?php echo $intersCount; ?></h1>
                        </div>
                        <div class="progress">
                            <svg>
                                <circle cx='38' cy='38' r='36'></circle>
                            </svg>
                            <div class="number">
                                <p>62%</p>
                            </div>
                        </div>
                    </div>
                    <small class="text-muted">Depuis le 21 avril 2023</small>
                </div>
                <!--------------- END OF EXPENSES ------------>
                <div class="income">
                    <span class="material-icons-sharp">stacked_line_chart</span>
                    <div class="middle">
                        <div class="left">
                            <h3>Nombre de clients</h3>
                            <h1><?php echo $clientsCount; ?></h1>
                        </div>
                        <div class="progress">
                            <svg>
                                <circle cx='38' cy='38' r='36'></circle>
                            </svg>
                            <div class="number">
                                <p>44%</p>
                            </div>
                        </div>
                    </div>
                    <small class="text-muted">Depuis le 21 avril 2023</small>
                </div>
                <!--------------- END OF INCOME ------------>
            </div>
            <!--------------- END OF INSIGHTS ------------>

            <div class="alert">
                <h2>Alertes</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Pièce</th>
                            <th>Copieur</th>
                            <th>Client</th>
                            <th>Limittes de la pièce</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Fordable Mini Drone</td>
                            <td>85631</td>
                            <td>Due</td>
                            <td class="warning">Pending</td>
                            <td class="primary">Details</td>
                        </tr>
                        <tr>
                            <td>Fordable Mini Drone</td>
                            <td>85631</td>
                            <td>Due</td>
                            <td class="warning">Pending</td>
                            <td class="primary">Details</td>
                        </tr>
                        <tr>
                            <td>Fordable Mini Drone</td>
                            <td>85631</td>
                            <td>Due</td>
                            <td class="warning">Pending</td>
                            <td class="primary">Details</td>
                        </tr>
                        <tr>
                            <td>Fordable Mini Drone</td>
                            <td>85631</td>
                            <td>Due</td>
                            <td class="warning">Pending</td>
                            <td class="primary">Details</td>
                        </tr>
                        <tr>
                            <td>Fordable Mini Drone</td>
                            <td>85631</td>
                            <td>Due</td>
                            <td class="warning">Pending</td>
                            <td class="primary">Details</td>
                        </tr>
                    </tbody>
                </table>
                <a href="">Show All</a>
            </div>
        </main>
        <!--------------- END OF MAIN ------------>

        <div class="right">
            <div class="top">
                <button id="menu-btn">
                    <span class="material-icons-sharp">menu</span>
                </button>
                <div class="theme-toggler">
                    <span class="material-icons-sharp active">light_mode</span>
                    <span class="material-icons-sharp">dark_mode</span>
                </div>
                <div class="profile">
                    <div class="info">
                        <p>Hey, <b><?php echo ucfirst($_SESSION['surname']); ?></b></p>
                        <small class="text-muted"><?php echo ucfirst($_SESSION['rang']); ?></small>
                    </div>
                    <div class="profile-photo">
                        <img src="./images/getImage.php?nom=<?php echo $_SESSION['photo']; ?>" alt="Photo de profil">
                    </div>
                </div>
            </div>
            <!--------------- END OF TOP ------------>
            <div class="recent-updates">
                <h2>Recent Updates</h2>
                <div class="updates">
                    <?php 
                    $file = "./json/logs.json";
                    $data = file_get_contents($file);
                    $obj = json_decode($data);
                    $loop = 0;
                    $now = time();
                    $sql = "SELECT `photo` FROM `utilisateurs` WHERE `id` = :id";
                    $stmt = $db->prepare($sql);
                    while ($loop <= 4 && isset($obj[$loop])) {
                        if (in_array($obj[$loop]->type, ['create', 'delete', 'update'])) {
                            // Récupérer le nom de l'image de profil de l'utilisateur
                            $userID = intval($obj[$loop]->userID);
                            $stmt->bindParam('id', $userID);
                            $stmt->execute();
                            $result = $stmt->fetch(PDO::FETCH_ASSOC);

                            // Calculer la différence des dates/heures
                            $date = strtotime($obj[$loop]->date);
                            $diff = abs($now - $date);
                            $days = floor($diff / (60 * 60 * 24));
                            $hours = floor(($diff % (60 * 60 * 24)) / (60 * 60));
                            $minutes = floor(($diff % (60 * 60)) / 60);
                            $seconds = $diff % 60;

                            $dateDiff = '';
                            if ($days > 0) {
                                $dateDiff .= $days . ($days > 1 ? ' jours' : ' jour') . ', ';
                            }
                            if ($hours > 0) {
                                $date = $minutes . ($minutes > 1 ? ' minutes' : ' minute');
                            }
                            if (2 <= $days && $days < 7) {
                                $dateDiff .= $hours . ($hours > 1 ? ' heures' : ' heure') . ' et ';
                            }
                            if ($minutes > 0) {
                                $dateDiff .= $minutes . ($minutes > 1 ? ' minutes' : ' minute');
                            }
                            if ($days == 0 && $hours == 0 && $minutes == 0) {
                                $dateDiff = $seconds . ($seconds > 1 ? ' secondes' : ' seconde');
                            }

                            echo '<div class="update">';
                            echo '<div class="profile-photo">';
                            echo '<img src="./images/getImage.php?nom=' . $result['photo'] . '">';
                            echo '</div>';
                            echo '<div class="message">';
                            echo '<p><b>' . ucfirst($obj[$loop]->surname) . ' ' . ucfirst($obj[$loop]->name) . '</b> ' . $obj[$loop]->action . '</p>';
                            echo '<small class="text-muted">Il y a ' . $date . '</small>';
                            echo '</div>';
                            echo '</div>';
                        }
                        $loop++;
                    }
                    ?>
                </div>
            </div>
            <!--------------- END OF RECENT UPDATES ------------>
            <div class="sales-analytics">
                <h2>Sales Analytics</h2>
                <div class="item online">
                    <div class="icon">
                        <span class="material-icons-sharp">shopping_cart</span>
                    </div>
                    <div class="right">
                        <div class="info">
                            <h3>ONLINE ORDERS</h3>
                            <small class="text-muted">Last 24 hours</small>
                        </div>
                        <h5 class="success">+39%</h5>
                        <h3>3849</h3>
                    </div>
                </div>
                <div class="item offline">
                    <div class="icon">
                        <span class="material-icons-sharp">local_mall</span>
                    </div>
                    <div class="right">
                        <div class="info">
                            <h3>OFFLINE ORDERS</h3>
                            <small class="text-muted">Last 24 hours</small>
                        </div>
                        <h5 class="danger">-17%</h5>
                        <h3>1100</h3>
                    </div>
                </div>
                <div class="item customers">
                    <div class="icon">
                        <span class="material-icons-sharp">person</span>
                    </div>
                    <div class="right">
                        <div class="info">
                            <h3>NEW CUSTOMERS</h3>
                            <small class="text-muted">Last 24 hours</small>
                        </div>
                        <h5 class="success">+25%</h5>
                        <h3>849</h3>
                    </div>
                </div>
                <div class="item add-product">
                    <div>
                        <span class="material-icons-sharp">add</span>
                        <h3>Add Product</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="./script/index.js"></script>
</body>

</html>

<?php
?>
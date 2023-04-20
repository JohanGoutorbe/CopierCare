<?php

//Affichage des erreurs sur la page web
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connexion à la base de données
include './dbconnect.php';

if (@isset($_SESSION['logged']) && @$_SESSION['logged'] == true) {
    $_SESSION['validate'] = true;
} else {
    $_SESSION['errors'] = "Veuillez vous authentifier à l'aide de l'une des méthodes ci-dessus.";
    header('Location: login.php');
    exit();
}

$sql = "SELECT * FROM `utilisateurs` WHERE `identifiant` = :username";
$stmt = $db->prepare($sql);
$stmt->bindParam('username', $username);
$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CopierCare - Pièces
    </title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+outlined">
    <link rel="stylesheet" href="./style/style.css">
    <link rel="shortcut icon" href="./files/logo_copiercare.png" type="image/x-icon">
</head>

<body>
    <div class="container">
        <aside>
            <div class="top">
                <div class="logo">
                    <img src="./getImage.php?nom=logo_copiercare.png" alt="CopierCare logo">
                    <h2><span class="danger">COPIER</span>CARE</h2>
                </div>
                <div class="close" id="close-btn">
                    <span class="material-icons-sharp">close</span>
                </div>
            </div>

            <div class="sidebar">
                <a href="./index.php">
                    <span class="material-icons-sharp">home</span>
                    <h3>Accueil</h3>
                </a>
                <a href="./alertes.php">
                    <span class="material-icons-sharp">report_gmailerrorred</span>
                    <h3>Alertes</h3>
                </a>
                <a href="./clients.php">
                    <span class="material-icons-sharp">groups</span>
                    <h3>Clients</h3>
                </a>
                <a href="./copieurs.php">
                    <span style="width: 24px;" class="material-icons-sharp">print_outline</span>
                    <h3>Copieurs</h3>
                </a>
                <a href="./consommables.php">
                    <span class="material-icons-sharp">construction</span>
                    <h3>Consommables</h3>
                </a>
                <a href="./pieces.php" class="active">
                    <span class="material-icons-sharp">devices</span>
                    <h3>Pièces</h3>
                </a>
                <a href="./parametres.php">
                    <span class="material-icons-sharp">settings</span>
                    <h3>Paramètres</h3>
                </a>
                <a href="./admin.php">
                    <span class="material-icons-sharp">admin_panel_settings</span>
                    <h3>Administrateur</h3>
                </a>
                <a href="./logout.php">
                    <span class="material-icons-sharp">logout</span>
                    <h3>Se déconnecter</h3>
                </a>
            </div>
        </aside>
        <!----------------------- END OF ASIDE ------------------------->

        <main>
            <h1>Liste des pièces</h1>
            <div class="alert">
                <h2><a href="?newpiece=oui" style="text-align:left;">Ajouter une pièce</a></h2>
            </div>
            <div class="alert">
                <h2>Pièces</h2>
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
                <a href="#">Show All</a>
            </div>
        </main>
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
                        <img src="./getImage.php?nom=<?php echo $_SESSION['photo']; ?>" alt="Photo de profil">
                    </div>
                </div>
            </div>
            <!--------------- END OF TOP ------------>
        </div>
    </div>

    <script src="./index.js"></script>
</body>

</html>
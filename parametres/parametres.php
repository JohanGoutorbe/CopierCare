<?php

//Affichage des erreurs sur la page web
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connexion à la base de données
include '../utils/dbconnect.php';

include '../utils/loggedVerif.php';

$sql = "SELECT * FROM `utilisateurs` WHERE `id` = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam('id', $_SESSION['id']);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

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
    <link rel="stylesheet" href="../style/style.css">
    <link rel="shortcut icon" href="../images/getImage.php?nom=logo_copiercare.png" type="image/x-icon">
</head>

<body>
    <div class="container">
        <aside>
            <div class="top">
                <a class="logo" href="..\index.php">
                    <img src="../images/getImage.php?nom=logo_copiercare.png" alt="CopierCare logo">
                    <h2><span class="danger">COPIER</span>CARE</h2>
                </a>
                <div class="close" id="close-btn">
                    <span class="material-icons-sharp">close</span>
                </div>
            </div>

            <div class="sidebar">
                <a href="../index.php">
                    <span class="material-icons-sharp">home</span>
                    <h3>Accueil</h3>
                </a>
                <a href="../alertes/alertes.php">
                    <span class="material-icons-sharp">report_gmailerrorred</span>
                    <h3>Alertes</h3>
                </a>
                <a href="../inters/inter.php">
                    <span class="material-icons-sharp">description</span>
                    <h3>Interventions</h3>
                </a>
                <a href="../clients/clients.php">
                    <span class="material-icons-sharp">groups</span>
                    <h3>Clients</h3>
                </a>
                <a href="../copieurs/copieurs.php">
                    <span style="width: 24px;" class="material-icons-sharp">print_outline</span>
                    <h3>Copieurs</h3>
                </a>
                <a href="../consommables/consommables.php">
                    <span class="material-icons-sharp">construction</span>
                    <h3>Consommables</h3>
                </a>
                <a href="../pieces/pieces.php">
                    <span class="material-icons-sharp">devices</span>
                    <h3>Pièces</h3>
                </a>
                <a href="" class="active">
                    <span class="material-icons-sharp">settings</span>
                    <h3>Paramètres</h3>
                </a>
                <a href="../admin/admin.php" <?php if ($_SESSION['rang'] !== 'admin') {
                                                    echo ' style="display:none;"';
                                                } ?>>
                    <span class="material-icons-sharp">admin_panel_settings</span>
                    <h3>Administrateur</h3>
                </a>
                <a href="../utils/logout.php">
                    <span class="material-icons-sharp">logout</span>
                    <h3>Se déconnecter</h3>
                </a>
            </div>
        </aside>
        <!----------------------- END OF ASIDE ------------------------->

        <main>
            <h1>Paramètres du profil</h1>
            <form class="profile" action="./parametres.php" method="post" enctype="multipart/form-data">
                <img style="margin-bottom: 1.5em;" src="../images/getImage.php?nom=<?php echo $_SESSION['photo']; ?>" alt="Photo de profil">
                <input type="file" name="file" id="file" accept="image/png, image/jpeg">
                <label for="file"><?php echo strtoupper('changer la photo') ?></label>
                <input type="text" name="nom" placeholder="Nom" <?php if (isset($_GET['empty']) && @$_GET['empty'] == true) {
                                                                    echo '';
                                                                } else {
                                                                    echo 'value="' . $row['nom'] . "\"";
                                                                } ?>>
                <input type="text" name="prenom" placeholder="Prénom" <?php if (isset($_GET['empty']) && @$_GET['empty'] == true) {
                                                                            echo '';
                                                                        } else {
                                                                            echo 'value="' . $row['prenom'] . "\"";
                                                                        } ?>>
                <input type="email" name="email" placeholder="Adresse mail" <?php if (isset($_GET['empty']) && @$_GET['empty'] == true) {
                                                                                echo '';
                                                                            } else {
                                                                                echo 'value="' . $row['email'] . "\"";
                                                                            } ?>>
                <input type="text" name="formation" placeholder="Formation" <?php if (isset($_GET['empty']) && $_GET['empty'] == true) {
                                                                                echo '';
                                                                            } else {
                                                                                echo 'value="' . $row['formation'] . "\"";
                                                                            } ?>>
                <input type="text" name="login" placeholder="Identifiant de connexion" <?php if (isset($_GET['empty']) && $_GET['empty'] == true) {
                                                                                            echo '';
                                                                                        } else {
                                                                                            echo 'value="' . $row['identifiant'] . "\"";
                                                                                        } ?>>
                <input type="password" name="pwd" placeholder="Mot de passe de connexion" <?php if (isset($_GET['empty']) && $_GET['empty'] == true) {
                                                                                                echo '';
                                                                                            } else {
                                                                                                echo 'value="' . $row['mdp'] . "\"";
                                                                                            } ?>>
                <div class="buttons">
                    <a href="./parametres.php?empty=true" class="BtnAdd" style="float: left; margin: 10px 0 0 5%;">Annuler</a>
                    <button type="submit" class="BtnAdd" style="float: right; margin: 10px 5% 0 0;">Valider</button>
                </div>
            </form>
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
                <a href="../parametres/parametres.php" class="profile">
                    <div class="info">
                        <p>Hey, <b><?php echo ucfirst($_SESSION['surname']); ?></b></p>
                        <small class="text-muted"><?php echo ucfirst($_SESSION['rang']); ?></small>
                    </div>
                    <div class="profile-photo">
                        <img src="../images/getImage.php?nom=<?php echo $_SESSION['photo']; ?>" alt="Photo de profil">
                    </div>
                </a>
            </div>
            <!--------------- END OF TOP ------------>
        </div>
    </div>

    <script src="../script/index.js"></script>
</body>

</html>
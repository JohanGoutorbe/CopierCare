<?php

//Affichage des erreurs sur la page web
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connexion à la base de données
include '../utils/dbconnect.php';

include '../utils/loggedVerif.php';

$sql = "SELECT * FROM `copieurs` WHERE 1";
$stmt = $db->prepare($sql);
$stmt->execute();

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
                <a class="logo" href="..\">
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
                <a href="" class="active">
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
                <a href="../parametres/parametres.php">
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
            <h1>Tableau de bord</h1>
            <div class="alert">
                <h2>Alertes</h2>
                <table>
                    <thead>
                        <tr>
                            <th style=" display: none;">ID</th>
                            <th>Marque</th>
                            <th>Modèle</th>
                            <th>Mise en service</th>
                            <th>Fin de garantie</th>
                            <th>Relevé compteur NB</th>
                            <th>Relevé compteur Couleur</th>
                            <th>Client</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($query = $stmt->fetch()) {
                            $request = "SELECT `nom_client` FROM `clients` WHERE `id` = :client_id";
                            $answer = $db->prepare($request);
                            $answer->execute(['client_id' => $query['client_id']]);
                            $row = $answer->fetch();
                            echo '<tr>';
                            echo '<td style="display: none;">' . $query['id'] . '</td>';
                            echo '<td>' . $query['marque'] . '</td>';
                            echo '<td>' . $query['modele'] . '</td>';
                            echo '<td>0' . $query['date_mise_en_service'] . '</td>';
                            echo '<td>' . $query['date_fin_garantie'] . '</td>';
                            echo '<td>' . $query['releve_compteur_nb'] . '</td>';
                            echo '<td>' . $query['releve_compteur_couleur'] . '</td>';
                            echo '<td>' . $row['nom_client'] . '</td>';
                            echo '<td>' . $query['options'] . '</td>';/*
                            echo '<td class="warning" style="max-width: 100px;"><a href="clients.php?update=true&id=' . $query['id'] . '&name=' . $query['nom_client'] . '&email=' . $query['email'] . '&tel=' . $query['tel'] . '&adresse=' . $query['adresse'] . '&interlocuteur=' . $query['interlocuteur'] . '" style="text-decoration: none; color: #ffbb55; cursor: pointer;"><span class="material-icons-sharp">edit</span></a></td>';
                            echo '<td class="danger" style="max-width: 100px;"><a href="deleteClient.php?id=' . $query['id'] . '&name=' . $query['nom_client'] . '" style="text-decoration: none; color: #ff7782; cursor: pointer;"><span class="material-icons-sharp">delete</span></a></td>';*/
                            echo '</tr>';
                        } ?>
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
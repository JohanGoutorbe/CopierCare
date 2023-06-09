<?php

//Affichage des erreurs sur la page web
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connexion à la base de données
include '../utils/dbconnect.php';

include '../utils/loggedVerif.php';

$sql = "SELECT * FROM `inters` WHERE 1 ORDER BY `id` DESC";
$stmt = $db->prepare($sql);
$stmt->execute();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CopierCare - Interventions
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
                <div class="logo">
                    <img src="../images/getImage.php?nom=logo_copiercare.png" alt="CopierCare logo">
                    <h2><span class="danger">COPIER</span>CARE</h2>
                </div>
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
                <a href="" class="active">
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
            <h1>Interventions</h1>
            <div class="alert">
                <button id="AddUserBtn" class="AddPieceBtn">
                    <h2>Ajouter un utilisateur</h2>
                </button>
                <section class="sales" id="addPiece">
                    <form action="./inter.php" method="POST" class="formAddPiece" enctype="multipart/form-data">
                        <div class="inputs">
                            <label for="interNumber">Numéro d'inter : </label>
                            <input type="text" name="interNumber" placeholder="Numéro de l'intervention" required>
                        </div>
                        <div class="inputs">
                            <label for="interDate">Date : </label>
                            <input type="date" name="interDate" required>
                        </div>
                        <div class="inputs">
                            <label>Client : </label>
                            <select style="padding:0.25rem; border:1px solid #ccc; border-radius:5px; width:159px;" name="interClient" id="" required>
                                <option value="" selected disabled hidden>Choisissez un client</option>
                                <?php
                                $sentence = "SELECT DISTINCT `id`, `nom_client` FROM `clients` WHERE 1";
                                $clients = $db->prepare($sentence);
                                $clients->execute();
                                while ($client = $clients->fetch()) {
                                    echo '<option style="padding:0.25rem; border:1px solid #ccc; border-radius:5px; width:159px;" value="' . $client['id'] . '">' . $client['nom_client'] . '</option>';
                                } ?>
                            </select>
                        </div>
                        <div class="inputs">
                            <label for="interCopieur">Copieur : </label>
                            <input type="text" name="interCopieur" placeholder="Copieur lié à l'intervention" required>
                        </div>
                        <div class="inputs">
                            <label for="interTech">Technicien : </label>
                            <input type="text" name="interTech" placeholder="Technicien de l'intervention" required>
                        </div>
                        <div class="inputs">
                            <label for="interCompteurNB">Compteur NB : </label>
                            <input type="number" name="interCompteurNB" required>
                        </div>
                        <div class="inputs">
                            <label for="interCompteurCouleur">Compteur Couleur : </label>
                            <input type="number" name="interCompteurCouleur" required>
                        </div>
                        <div class="inputs">
                            <label for="interPanne">Panne :   </label>
                            <textarea rows='3' cols='50' name='interPanne' placeholder="Panne du copieur"></textarea>
                        </div>
                        <div class="inputs">
                            <label for="interDiag">Dagnostic :   </label>
                            <textarea rows='3' cols='50' name='interDiag' placeholder="Diagnostic de la panne"></textarea>
                        </div>
                        <div class="inputs">
                            <label for="interWork">Travaux :   </label>
                            <textarea rows='3' cols='50' name='interWork' placeholder="Travaux sur le copieur"></textarea>
                        </div>
                        <div class="inputs">
                            <label for="interPieces">Pieces :   </label>
                            <textarea rows='3' cols='50' name='interPieces' placeholder="Pieces changées du copieur"></textarea>
                        </div>
                        <button type="submit" name="userSubmit" value="Add an User" class="BtnAdd">
                            <h2 style="color: #7380ec;">Valider</h2>
                        </button>
                    </form>
                </section>
                <?php if (isset($_SESSION['messageAdmin'])) {
                    echo $_SESSION['messageAdmin'];
                } ?>
            </div>
            <div class="alert bis">
                <h2>Alertes</h2>
                <table>
                    <thead>
                        <tr>
                            <th style=" display: none;">ID</th>
                            <th>Numéro d'inter</th>
                            <th>Date</th>
                            <th>Client</th>
                            <th>Copieur</th>
                            <th>Technicien</th>
                            <th>Compteur NB</th>
                            <th>Compteur Couleur</th>
                            <th>Panne</th>
                            <th>Diagnostic</th>
                            <th>Travaux</th>
                            <th>Pièces changées</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($query = $stmt->fetch()) {
                            $request = "SELECT `nom_client` FROM `clients` WHERE `id` = :client_id";
                            $answer = $db->prepare($request);
                            $answer->execute(['client_id' => $query['client_id']]);
                            $row = $answer->fetch();

                            $request2 = "SELECT `marque`, `modele` FROM `copieurs` WHERE `id` = :copieur_id";
                            $answer2 = $db->prepare($request2);
                            $answer2->execute(['copieur_id' => $query['copieur_id']]);
                            $row2 = $answer2->fetch();

                            $request3 = "SELECT `nom`, `prenom` FROM `utilisateurs` WHERE `id` = :tech_id";
                            $answer3 = $db->prepare($request3);
                            $answer3->execute(['tech_id' => $query['tech_id']]);
                            $row3 = $answer3->fetch();
                            echo '<tr>';
                            echo '<td style="display: none;">' . $query['id'] . '</td>';
                            echo '<td>' . $query['num_gestco'] . '</td>';
                            echo '<td>' . $query['date'] . '</td>';
                            echo '<td>' . $row['nom_client'] . '</td>';
                            echo '<td>' . ucfirst($row2['marque']) . " " . $row2['modele'] . '</td>';
                            echo '<td>' . ucfirst($row3['prenom']) . " " . strtoupper($row3['nom']) . '</td>';
                            echo '<td>' . $query['compteur_nb'] . '</td>';
                            echo '<td>' . $query['compteur_couleur'] . '</td>';
                            echo '<td>' . $query['panne'] . '</td>';
                            echo '<td>' . $query['diagnostic'] . '</td>';
                            echo '<td>' . $query['travaux'] . '</td>';
                            echo '<td>' . $query['liste_pieces_changees'] . '</td>';
                            echo '</tr>';
                        } ?>
                    </tbody>
                </table>
                <a href="#">Voir tout</a>
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
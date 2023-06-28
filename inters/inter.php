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

if (isset($_POST['userSubmit'])) {
    $inter = htmlspecialchars($_POST['interNumber']);
    $date = htmlspecialchars($_POST['interDate']);
    $client = htmlspecialchars($_POST['interClient']);
    $copieur = htmlspecialchars($_POST['interCopieur']);
    $tech = htmlspecialchars($_POST['interTech']);
    $compteurNB = htmlspecialchars($_POST['interCompteurNB']);
    $compteurCouleur = htmlspecialchars($_POST['interCompteurCouleur']);
    $panne = htmlspecialchars($_POST['interPanne']);
    $diag = htmlspecialchars($_POST['interDiag']);
    $travaux = htmlspecialchars($_POST['interWork']);
    $pieces = htmlspecialchars($_POST['interPieces']);

    if (!empty($inter)) {
        if (!empty($date)) {
            if (!empty($client)) {
                if (!empty($copieur)) {
                    if (!empty($tech)) {
                        if (!empty($compteurNB)) {
                            if (!empty($compteurCouleur)) {
                                if (ctype_digit($inter)) {
                                    if (strlen($inter) < 10) {
                                        if (strlen($date) < 15) {
                                            if (strlen($client) < 10) {
                                                if (strlen($copieur) < 10) {
                                                    if (strlen($tech) < 10) {
                                                        if (strlen($compteurNB) < 10000000) {
                                                            if (strlen($compteurCouleur) < 10000000) {
                                                                if (strlen($pieces) < 250) {
                                                                    $sql = "INSERT INTO `inters` (`num_gestco`, `date`, `client_id`, `copieur_id`, `tech_id`, `compteur_nb`, `compteur_couleur`, `panne`, `diagnostic`, `travaux`, `liste_pieces_changees`) VALUES (:num, :date, :client, :copieur, :tech, :comptNB, :comptC, :panne, :diag, :travaux, :pieces)";
                                                                    $stmt = $db->prepare($sql);
                                                                    $stmt->bindParam('num', $inter);
                                                                    $stmt->bindParam('date', $date);
                                                                    $stmt->bindParam('client', $client);
                                                                    $stmt->bindParam('copieur', $copieur);
                                                                    $stmt->bindParam('tech', $tech);
                                                                    $stmt->bindParam('comptNB', $compteurNB);
                                                                    $stmt->bindParam('comptC', $compteurCouleur);
                                                                    $stmt->bindParam('panne', $panne);
                                                                    $stmt->bindParam('diag', $diag);
                                                                    $stmt->bindParam('travaux', $travaux);
                                                                    $stmt->bindParam('pieces', $pieces);
                                                                    $stmt->execute();

                                                                    $type = "create";
                                                                    $action = "a ajouté l'intervention " . $inter . " à la liste des interventions";
                                                                    include '../utils/log.php';

                                                                    $_SESSION['message'] = '<p style="color: #41f1b6; text-shadow: 0px 0px black; width: auto; font-size:16px;">L\'intervention ' . $inter . ' a bien été ajouté.</p>';
                                                                    header("Refresh:0");
                                                                } else {
                                                                    $_SESSION['message'] = '<p style="color: #ff7782;">La liste des pièces changées est trop longue (250 caractères maximum)</p>';
                                                                }
                                                            } else {
                                                                $_SESSION['message'] = '<p style="color: #ff7782;">Le relevé compteur Couleur est trop long</p>';
                                                            }
                                                        } else {
                                                            $_SESSION['message'] = '<p style="color: #ff7782;">Le relevé compteur NB est trop long</p>';
                                                        }
                                                    } else {
                                                        $_SESSION['message'] = '<p style="color: #ff7782;">Le nom du technicien est trop long</p>';
                                                    }
                                                } else {
                                                    $_SESSION['message'] = '<p style="color: #ff7782;">Le nom du copieur est trop long</p>';
                                                }
                                            } else {
                                                $_SESSION['message'] = '<p style="color: #ff7782;">Le nom du client est trop long</p>';
                                            }
                                        } else {
                                            $_SESSION['message'] = '<p style="color: #ff7782;">La date est trop longue</p>';
                                        }
                                    } else {
                                        $_SESSION['message'] = '<p style="color: #ff7782;">Le numéro d\'intervention est trop long</p>';
                                    }
                                } else {
                                    $_SESSION['message'] = '<p style="color: #ff7782;">Le numéro de l\'intervention est incorrect</p>';
                                }
                            } else {
                                $_SESSION['message'] = '<p style="color: #ff7782;">Le compteur couleur du copieur est vide</p>';
                            }
                        } else {
                            $_SESSION['message'] = '<p style="color: #ff7782;">Le compteur NB du copieur est vide</p>';
                        }
                    } else {
                        $_SESSION['message'] = '<p style="color: #ff7782;">Le technicien de l\'intervention est vide</p>';
                    }
                } else {
                    $_SESSION['message'] = '<p style="color: #ff7782;">Le copieur de l\'intervention est vide</p>';
                }
            } else {
                $_SESSION['message'] = '<p style="color: #ff7782;">Le client de l\'intervention est vide</p>';
            }
        } else {
            $_SESSION['message'] = '<p style="color: #ff7782;">La date de l\'intervention est vide</p>';
        }
    } else {
        $_SESSION['message'] = '<p style="color: #ff7782;">Le numéro de l\'intervention est vide</p>';
    }
}

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
                            <?php $getdt = new \DateTime(); $dt = $getdt->format('Y-m-d'); ?>
                            <label for="interDate">Date : </label>
                            <input type="date" name="interDate" min="2023-01-01" value="<?php echo $dt; ?>" required>
                        </div>
                        <div class="inputs">
                            <label>Client : </label>
                            <select style="padding:0.25rem; border:1px solid #ccc; border-radius:5px; width:159px;" name="interClient" required>
                                <option value="" selected disabled hidden>Sélectionnez un client</option>
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
                            <label>Copieur : </label>
                            <select style="padding:0.25rem; border:1px solid #ccc; border-radius:5px; width:159px;" name="interCopieur" required>
                                <option value="" selected disabled hidden>Sélectionnez un copieur</option>
                                <?php
                                $sentence = "SELECT DISTINCT `id`, `marque`, `modele` FROM `copieurs` WHERE 1";
                                $copieurs = $db->prepare($sentence);
                                $copieurs->execute();
                                while ($copieur = $copieurs->fetch()) {
                                    echo '<option style="padding:0.25rem; border:1px solid #ccc; border-radius:5px; width:159px;" value="' . $copieur['id'] . '">' . $copieur['marque'] . " " . $copieur['modele'] . '</option>';
                                } ?>
                            </select>
                        </div>
                        <div class="inputs">
                            <label>Technicien : </label>
                            <select style="padding:0.25rem; border:1px solid #ccc; border-radius:5px; width:159px;" name="interTech" required>
                                <option value="" selected disabled hidden>Sélectionnez un technicien</option>
                                <?php
                                $sentence = "SELECT DISTINCT `id`, `nom`, `prenom` FROM `utilisateurs` WHERE 1";
                                $users = $db->prepare($sentence);
                                $users->execute();
                                while ($user = $users->fetch()) {
                                    echo '<option style="padding:0.25rem; border:1px solid #ccc; border-radius:5px; width:159px;" value="' . $user['id'] . '">' . ucfirst($user['prenom']) . ' ' . strtoupper($user['nom']) . '</option>';
                                } ?>
                            </select>
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
                            <label for="interPanne">Panne : </label>
                            <textarea rows='3' cols='50' name='interPanne' placeholder="Panne du copieur"></textarea>
                        </div>
                        <div class="inputs">
                            <label for="interDiag">Dagnostic : </label>
                            <textarea rows='3' cols='50' name='interDiag' placeholder="Diagnostic de la panne"></textarea>
                        </div>
                        <div class="inputs">
                            <label for="interWork">Travaux : </label>
                            <textarea rows='3' cols='50' name='interWork' placeholder="Travaux sur le copieur"></textarea>
                        </div>
                        <div class="inputs">
                            <label for="interPieces">Pieces : </label>
                            <textarea rows='3' cols='50' name='interPieces' placeholder="Pieces changées du copieur"></textarea>
                        </div>
                        <button type="submit" name="userSubmit" value="Add an User" class="BtnAdd">
                            <h2 style="color: #7380ec;">Valider</h2>
                        </button>
                    </form>
                </section>
                <?php if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
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
    <script src="../script/pieces.js"></script>
</body>

</html>
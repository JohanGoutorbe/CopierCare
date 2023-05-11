<?php

//Affichage des erreurs sur la page web
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connexion à la base de données
include '../utils/dbconnect.php';

include '../utils/loggedVerif.php';

$sql = "SELECT * FROM `clients` WHERE 1 ORDER BY `nom_client`";
$stmt = $db->prepare($sql);
$stmt->execute();

if (isset($_POST[('pieceSubmit')])) {
    if (!empty($_POST['pieceName']) && !empty($_POST['pieceRef'])) {
        $pieceName = htmlspecialchars($_POST['pieceName']);
        $pieceRef = htmlspecialchars($_POST['pieceRef']);
        if (strlen($pieceName) < 100 && strlen($pieceRef) < 20) {
            if (strlen($pieceName) >= strlen($pieceRef)) {
                $Crud = 'C';
                $sql = "INSERT INTO `pieces` (`nom`, `ref`) VALUES (:name, :ref)";
                $stmt = $db->prepare($sql);
                $stmt->bindParam('name', $pieceName);
                $stmt->bindParam('ref', $pieceRef);
                $stmt->execute();
                $_SESSION['message'] = '<p style="color: #41f1b6; text-shadow: 0px 0px black;">La pièce <strong>' . $pieceName . '</strong> a bien été ajoutée.</p>';
                header("Refresh:0");
            } else {
                $_SESSION['message'] = '<p style="color: #ff7782;">La référence doit être plus courte que le nom</p>';
            }
        } else {
            $_SESSION['message'] = '<p style="color: #ff7782;">Le nom ou la référence de la pièce est trop long.</p>';
        }
    } else {
        $_SESSION['message'] = '<p style="color: #ff7782;">Le nom et/ou la référence est vide.</p>';
    }
}

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
    <link rel="stylesheet" href="../style/modal_style.css">
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
                <a href="../inters/inter.php">
                    <span class="material-icons-sharp">description</span>
                    <h3>Interventions</h3>
                </a>
                <a href="" class="active">
                    <span class="material-icons-sharp">groups</span>
                    <h3>Clients</h3>
                </a>
                <a href="../copieurs/copieurs.php">
                    <span style="width: 24px;" class="material-icons-sharp">print_outline</span>
                    <h3>Copieurs</h3>
                </a>
                <a href="../parametres/parametres.php">
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
            <h1>Liste des clients</h1>
            <div class="alert">
                <button id="AddPieceBtn" class="AddPieceBtn">
                    <h2>Ajouter un client</h2>
                </button>
                <section class="sales" id="addPiece">
                    <form action="./clients.php" method="POST" class="formAddPiece ">
                        <div class="inputs">
                            <label for="clientName">Nom : </label>
                            <input type="text" name="clientName" placeholder="Société Exemple" required>
                        </div>
                        <div class="inputs">
                            <label for="clientEmail">Email : </label>
                            <input type="text" name="clientEmail" placeholder="exemple@gmail.com" autocomplete="off" required>
                        </div>
                        <div class="inputs">
                            <label for="clientPhone">Tel : </label>
                            <input type="text" name="clientPhone" placeholder="01 02 03 04 05" required>
                        </div>
                        <div class="inputs">
                            <label for="clientAdress">Adresse : </label>
                            <input type="text" name="clientAdress" placeholder="Digne-les-Bains" required>
                        </div>
                        <div class="inputs">
                            <label for="interlocutor">Interlocuteur : </label>
                            <input type="text" name="interlocutor" placeholder="Jean Martin" required>
                        </div>
                        <button type="submit" name="clientSubmit" value="Add a Client" class="BtnAdd">
                            <h2>Valider</h2>
                        </button>
                    </form>
                </section>
                <?php if (isset($_SESSION['clientMessage'])) {
                    echo $_SESSION['clientMessage'];
                } ?>
            </div>
            <div class=" alert bis">
                <h2>Pièces</h2>
                <table>
                    <thead>
                        <tr>
                            <th style=" display: none;">ID</th>
                            <th>Nom client</th>
                            <th>Email</th>
                            <th>Tel</th>
                            <th>Adresse</th>
                            <th>Interlocuteur</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($query = $stmt->fetch()) {
                            echo '<tr>';
                            echo '<td style="display: none;">' . $query['id'] . '</td>';
                            echo '<td>' . $query['nom_client'] . '</td>';
                            echo '<td>' . $query['email'] . '</td>';
                            echo '<td>' . $query['tel'] . '</td>';
                            echo '<td>' . $query['adresse'] . '</td>';
                            echo '<td>' . $query['interlocuteur'] . '</td>';
                            echo '<td class="warning" style="max-width: 100px;"><a href="clients.php?update=true&id=' . $query['id'] . '&name=' . $query['nom_client'] . '&email=' . $query['email'] . '&tel=' . $query['tel'] . '&adresse=' . $query['adresse'] . '&interlocuteur=' . $query['interlocuteur'] . '" style="text-decoration: none; color: #ffbb55; cursor: pointer;"><span class="material-icons-sharp">edit</span></a></td>';
                            echo '<td class="danger" style="max-width: 100px;"><a href="deleteClient.php?id=' . $query['id'] . '&name=' . $query['nom_client'] . '" style="text-decoration: none; color: #ff7782; cursor: pointer;"><span class="material-icons-sharp">delete</span></a></td>';
                            echo '</tr>';
                        } ?>
                    </tbody>
                </table>
            </div>
        </main>

        <section id="modal" class="modal" aria-hidden="true" role="dialog" aria_labelledby="titlemodal" style="<?php if (isset($_GET['update'])) {
                                                                                                                    echo 'visibility: visible; opacity: 1;';
                                                                                                                } else {
                                                                                                                    echo 'visibility: hidden; opacity: 0';
                                                                                                                } ?>">
            <div class="modal-wrapper">
                <form action="./updateClient.php" method="post" class="form1">
                    <h1 id="titlemodal">Modifier le client suivant :<br><?php if (isset($_GET['name'])) {
                                                                            echo $_GET['name'];
                                                                        } ?></h1>
                    <div class="inputs">
                        <input name="id" type="number" style="display: none;" value="<?php echo $_GET['id']; ?>">
                        <input name="name" type="text" placeholder="Nom du client" value="<?php echo $_GET['name']; ?>">
                        <input name="email" type="email" placeholder="Email du client" value="<?php echo $_GET['email']; ?>">
                        <input name="tel" type="text" placeholder="Téléphone du client" value="<?php echo $_GET['tel']; ?>">
                        <input name="adresse" type="text" placeholder="adresse du client" value="<?php echo $_GET['adresse']; ?>">
                        <input name="interlocuteur" type="text" placeholder="Interlocuteur" value="<?php echo $_GET['interlocuteur']; ?>">
                        <button type="submit" name="clientUpdateSubmit">Appliquer les modifications</button>
                    </div>
                </form>
            </div>
        </section>
        <!----------------------- END OF MODAL ------------------------->

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
                        <img src="../images/getImage.php?nom=<?php echo $_SESSION['photo']; ?>" alt="Photo de profil">
                    </div>
                </div>
            </div>
            <!--------------- END OF TOP ------------>
        </div>
    </div>

    <script src="../script/index.js"></script>
    <script src="../script/pieces.js"></script>
</body>

</html>
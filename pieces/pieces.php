<?php

error_reporting(0);

// Connexion à la base de données
include '../utils/dbconnect.php';

include '../utils/loggedVerif.php';

$sql = "SELECT * FROM `pieces` WHERE 1 ORDER BY id DESC";
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

                $type = "create";
                $action = "a ajouté la pièce " . $pieceName . " à la liste des pièces";
                include '../utils/log.php';

                $_SESSION['message'] = '<p style="color: #41f1b6; text-shadow: 0px 0px black; width: auto;">La pièce <strong>' . $pieceName . '</strong> a bien été ajoutée.</p>';
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
    <title>CopierCare - Pièces
    </title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+outlined">
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/modal_style.css">
    <link rel="shortcut icon" href="../images/getImage.php?nom=logo_copiercare.png" type="image/x-icon">
</head>

<body>
    <div class="container" style="grid-template-columns: 14rem auto 18rem;">
        <aside>
            <div class=" top">
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
                <a href="" class="active">
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
            <h1>Liste des pièces</h1>
            <div class="alert">
                <button id="AddPieceBtn" class="AddPieceBtn">
                    <h2>Ajouter une pièce</h2>
                </button>
                <section class="sales" id="addPiece">
                    <form action="./pieces.php" method="POST" class="formAddPiece ">
                        <div class="inputs">
                            <label for="pieceName">Désignation : </label>
                            <input type="text" name="pieceName" placeholder="Exemple" required>
                        </div>
                        <div class="inputs">
                            <label for="pieceRef">Référence : </label>
                            <input type="text" name="pieceRef" placeholder="ex" required>
                        </div>
                        <button type="submit" name="pieceSubmit" value="Add a Piece" class="BtnAdd">
                            <h2 style="color: #7380ec;">Valider</h2>
                        </button>
                    </form>
                </section>
                <?php if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                } ?>
            </div>
            <div class=" alert bis">
                <h2>Pièces</h2>
                <table>
                    <thead>
                        <tr>
                            <th style=" display: none;">ID</th>
                            <th>Nom</th>
                            <th>Référence</th>
                            <th>Modifier</th>
                            <th>Supprimer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalLignes = $stmt->rowCount();
                        $lignesAffichees = 8;
                        $i = 1;
                        while ($query = $stmt->fetch()) {
                            echo '<tr>';
                            echo '<td style="display: none;">' . $query['id'] . '</td>';
                            echo '<td>' . $query['nom'] . '</td>';
                            echo '<td>' . $query['ref'] . '</td>';
                            echo '<td class="warning" style="max-width: 100px;"><a href="pieces.php?update=true&id=' . $query['id'] . '&name=' . $query['nom'] . '&ref=' . $query['ref'] . '" style="text-decoration: none; color: #ffbb55; cursor: pointer;"><span class="material-icons-sharp">edit</span></a></td>';
                            echo '<td class="danger" style="max-width: 100px;"><a href="deletePiece.php?id=' . $query['id'] . '&name=' . $query['nom'] . '" style="text-decoration: none; color: #ff7782; cursor: pointer;"><span class="material-icons-sharp">delete</span></a></td>';
                            echo '</tr>';
                            if ($i >= $lignesAffichees) {
                                break;
                            } else {
                                $i++;
                            }
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
                <form action="./updatePiece.php" method="post" class="form1">
                    <h1 id="titlemodal">Modifier la pièce :<br><?php if (isset($_GET['name'])) {
                                                                    echo $_GET['name'];
                                                                } ?></h1>
                    <div class="inputs">
                        <input name="id" type="number" style="display: none;" value="<?php echo $_GET['id']; ?>">
                        <input name="name" type="text" placeholder="Nom de la pièce" value="<?php echo $_GET['name']; ?>">
                        <input name="ref" type="text" placeholder="Référence de la pièce" value="<?php echo $_GET['ref']; ?>">
                        <button type="submit" name="pieceUpdateSubmit">Appliquer les modifications</button>
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
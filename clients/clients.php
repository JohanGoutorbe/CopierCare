<?php

error_reporting(0);

// Connexion à la base de données
include '../utils/dbconnect.php';

include '../utils/loggedVerif.php';

$sql = "SELECT * FROM `clients` WHERE 1 ORDER BY `nom_client`";
$stmt = $db->prepare($sql);
$stmt->execute();

if (isset($_POST['clientSubmit'])) {
    $name = htmlspecialchars($_POST['clientName']);
    $email = htmlspecialchars($_POST['clientEmail']);
    $tel = htmlspecialchars($_POST['clientPhone']);
    $adress = htmlspecialchars($_POST['clientAdress']);
    $interlocuteur = htmlspecialchars($_POST['interlocutor']);
    if (!empty($name)) {
        if (!empty($email)) {
            if (!empty($tel)) {
                if (!empty($adress)) {
                    if (!empty($interlocuteur)) {
                        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            if (strlen($name) < 100) {
                                if (strlen($email) < 100) {
                                    if (strlen($tel) < 10) {
                                        if (strlen($adress) < 250) {
                                            if (strlen($interlocuteur) < 100) {
                                                $sql = "INSERT INTO `clients` (`nom_client`, `email`, `tel`, `adresse`, `interlocuteur`) VALUES (:name, :email, :tel, :adress, :interlocuteur)";
                                                $stmt = $db->prepare($sql);
                                                $stmt->bindParam('name', $name);
                                                $stmt->bindParam('email', $email);
                                                $stmt->bindParam('tel', $tel);
                                                $stmt->bindParam('adresse', $adress);
                                                $stmt->bindParam('interlocuteur', $interlocuteur);
                                                $stmt->execute();

                                                $type = "create";
                                                $action = "a ajouté le client " . $name . " à la liste des clients";
                                                include '../utils/log.php';

                                                $_SESSION['message'] = '<p style="color: #41f1b6; text-shadow: 0px 0px black; width: auto;">Le client <strong>' . $name . '</strong> a bien été ajouté.</p>';
                                                header("Refresh:0");
                                            } else {
                                                $_SESSION['message'] = '<p style="color: #ff7782;">Le nom du client est vide</p>';
                                            }
                                        } else {
                                            $_SESSION['message'] = '<p style="color: #ff7782;">Le nom du client est vide</p>';
                                        }
                                    } else {
                                        $_SESSION['message'] = '<p style="color: #ff7782;">Le nom du client est vide</p>';
                                    }
                                } else {
                                    $_SESSION['message'] = '<p style="color: #ff7782;">Le nom du client est vide</p>';
                                }
                            } else {
                                $_SESSION['message'] = '<p style="color: #ff7782;">Le nom du client est vide</p>';
                            }
                        } else {
                            $_SESSION['message'] = '<p style="color: #ff7782;">Le nom du client est vide</p>';
                        }
                    } else {
                        $_SESSION['message'] = '<p style="color: #ff7782;">Le nom du client est vide</p>';
                    }
                } else {
                    $_SESSION['message'] = '<p style="color: #ff7782;">Le nom du client est vide</p>';
                }
            } else {
                $_SESSION['message'] = '<p style="color: #ff7782;">Le nom du client est vide</p>';
            }
        } else {
            $_SESSION['message'] = '<p style="color: #ff7782;">Le nom du client est vide</p>';
        }
    } else {
        $_SESSION['message'] = '<p style="color: #ff7782;">Le nom du client est vide</p>';
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
                            <input type="text" name="clientPhone" placeholder="0102030405" required>
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
                            echo '<td>0' . $query['tel'] . '</td>';
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
                        <input name="tel" type="text" placeholder="Téléphone du client" value="<?php echo '0' . $_GET['tel']; ?>">
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
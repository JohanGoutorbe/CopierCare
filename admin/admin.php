<?php

//Affichage des erreurs sur la page web
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connexion à la base de données
include '../utils/dbconnect.php';

include '../utils/loggedVerif.php';

$sql = "SELECT * FROM `utilisateurs` WHERE 1 ORDER BY id";
$stmt = $db->prepare($sql);
$stmt->execute();

if (isset($_POST[('userSubmit')])) {
    if (isset($_POST['userName']) || !empty($_POST['userName']) || strlen($_POST['userName']) <= 50) {
        if (isset($_POST['userSurname']) || !empty($_POST['userSurname']) || strlen($_POST['userSurname']) <= 50) {
            if (isset($_POST['userEmail']) || !empty($_POST['userEmail']) || strlen($_POST['userEmail']) <= 100 || filter_var($_POST['userEmail'], FILTER_VALIDATE_EMAIL)) {
                if (isset($_POST['userRang']) || !empty($_POST['userRang']) || strlen($_POST['userRang']) <= 50 || ctype_alpha($_POST['userRang'])) {
                    if (isset($_POST['userImage']) || !empty($_POST['userImage']) || isset($_FILES["userImage"]) || !empty($_FILES["userImage"])) {
                        if (isset($_POST['userFormation'])) {
                            if (isset($_POST['userLogin']) || !empty($_POST['userLogin'] || strlen($_POST['userLogin']) <= 30)) {
                                if (isset($_POST['userPwd']) || !empty($_POST['userPwd']) || strlen($_POST['userPwd']) <= 50) {
                                    // Insertion de l'image de profil dans la table 'images'
                                    $sql = $db->prepare("insert into images(nom,taille,bin) values(?,?,?)");
                                    $sql->execute(array($_FILES["userImage"]["name"], $_FILES["userImage"]["size"], file_get_contents($_FILES["userImage"]["tmp_name"])));

                                    // Variables
                                    $nom = strtolower(htmlspecialchars($_POST['userName']));
                                    $prenom = strtolower(htmlspecialchars($_POST['userSurname']));
                                    $email = htmlspecialchars($_POST['userEmail']);
                                    $rang = strtolower(htmlspecialchars($_POST['userRang']));
                                    $formation = htmlspecialchars($_POST['userFormation']);
                                    $login = htmlspecialchars($_POST['userLogin']);
                                    $pwd = htmlspecialchars($_POST['userPwd']);

                                    // Insertion de l'utilisateur
                                    $sql = "INSERT INTO `utilisateurs` (`nom`, `prenom`, `email`, `rang`, `photo`, `formation`, `identifiant`, `mdp`) VALUES (:nom, :prenom, :email, :rang, :photo, :formation, :identifiant, :mdp)";
                                    $stmt = $db->prepare($sql);
                                    $stmt->bindParam('nom', $nom);
                                    $stmt->bindParam('prenom', $prenom);
                                    $stmt->bindParam('email', $email);
                                    $stmt->bindParam('rang', $rang);
                                    $stmt->bindParam('photo', $_FILES["userImage"]["name"]);
                                    $stmt->bindParam('formation', $formation);
                                    $stmt->bindParam('identifiant', $login);
                                    $stmt->bindParam('mdp', $pwd);
                                    $stmt->execute();
                                    $_SESSION['messageAdmin'] = '<p style="color: #41f1b6; text-shadow: 0px 0px black; width: auto;">L\'utilisateur <strong>' . ucfirst($prenom) . ' ' . strtoupper($nom) . '</strong> a bien été ajouté.</p>';
                                    header("Refresh:0");
                                } else {
                                    $_SESSION['messageAdmin'] = '<p style="color: #ff7782;">Le mot de passe du technicien est incorrecte</p>';
                                }
                            } else {
                                $_SESSION['messageAdmin'] = '<p style="color: #ff7782;">Le nom d\'utilisateur du technicien est incorrecte</p>';
                            }
                        } else {
                            $_SESSION['messageAdmin'] = '<p style="color: #ff7782;">La formation associée au technicien est incorrecte</p>';
                        }
                    } else {
                        $_SESSION['messageAdmin'] = '<p style="color: #ff7782;">L\'image associée au technicien est incorrecte</p>';
                    }
                } else {
                    $_SESSION['messageAdmin'] = '<p style="color: #ff7782;">Le rang du technicien est incorrect</p>';
                }
            } else {
                $_SESSION['messageAdmin'] = '<p style="color: #ff7782;">L\'adresse email du technicien est incorrecte</p>';
            }
        } else {
            $_SESSION['messageAdmin'] = '<p style="color: #ff7782;">Le prénom du technicien est incorrect</p>';
        }
    } else {
        $_SESSION['messageAdmin'] = '<p style="color: #ff7782;">Le nom du technicien est incorrect</p>';
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CopierCare - Espace Administration
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
                <a href="" class="active">
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
            <h1>Administration du site</h1>
            <div class="alert">
                <button id="AddUserBtn" class="AddPieceBtn">
                    <h2>Ajouter un utilisateur</h2>
                </button>
                <section class="sales" id="addPiece">
                    <form action="./admin.php" method="POST" class="formAddPiece" enctype="multipart/form-data">
                        <div class="inputs">
                            <label for="userName">Nom : </label>
                            <input type="text" name="userName" placeholder="Nom de l'utilisateur" required>
                        </div>
                        <div class="inputs">
                            <label for="userSurname">Prénom : </label>
                            <input type="text" name="userSurname" placeholder="Prénom de l'utilisateur" required>
                        </div>
                        <div class="inputs">
                            <label for="userEmail">Email : </label>
                            <input type="text" name="userEmail" placeholder="Email de l'utilisateur" required>
                        </div>
                        <div class="inputs">
                            <label for="userRang">Rang : </label>
                            <input type="text" name="userRang" placeholder="Admin - Tech - Test" required>
                        </div>
                        <div class="inputs">
                            <label for="userImage">Photo de profil</label>
                            <input type="file" name="userImage" accept="image/png, image/jpeg" required style="max-width: 200px; margin-left: 1em;">
                        </div>
                        <div class="inputs">
                            <label for="userFormation">Formation : </label>
                            <input type="text" name="userFormation" placeholder="Laisser vide si pas de formation">
                        </div><br>
                        <div class="inputs">
                            <label for="userLogin">Identifiant : </label>
                            <input type="text" name="userLogin" placeholder="Identifiant de connexion" required>
                        </div>
                        <div class="inputs">
                            <label for="userPwd">Mot de passe : </label>
                            <input type="password" name="userPwd" placeholder="Mot de passe de connexion" required>
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
            <div class=" alert bis">
                <h2>Utilisateurs</h2>
                <table>
                    <thead>
                        <tr>
                            <th style=" display: none;">ID</th>
                            <th>Technicien</th>
                            <th>Mail</th>
                            <th>Rang</th>
                            <th class="formation">Formation</th>
                            <th>Modifier</th>
                            <th>Supprimer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($query = $stmt->fetch()) {
                            echo '<tr>';
                            echo '<td style="display: none;">' . $query['id'] . '</td>';
                            echo '<td>' . ucfirst($query['prenom']) . ' ' . strtoupper($query['nom']) . '</td>';
                            echo '<td>' . $query['email'] . '</td>';
                            echo '<td>' . ucfirst($query['rang']) . '</td>';
                            echo '<td class="formation">' . $query['formation'] . '</td>';
                            echo '<td class="warning" style="max-width: 100px;"><a href="admin.php?update=true&id=' . $query['id'] . '&nom=' . $query['nom'] . '&prenom=' . $query['prenom'] . '&email=' . $query['email'] . '&rang=' . $query['rang'] . '&formation=' . $query['formation'] . '" style="text-decoration: none; color: #ffbb55; cursor: pointer;"><span class="material-icons-sharp">edit</span></a></td>';
                            echo '<td class="danger" style="max-width: 100px;"><a href="deleteUser.php?id=' . $query['id'] . '&nom=' . $query['nom'] . '&prenom=' . $query['prenom'] . '" style="text-decoration: none; color: #ff7782; cursor: pointer;"><span class="material-icons-sharp">delete</span></a></td>';
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
                <form action="./updateUser.php" method="post" class="form1">
                    <h1 id="titlemodal">Modifier l'utilisateur :<br><?php if (isset($_GET['nom']) && isset($_GET['prenom'])) {
                                                                        echo ucfirst($_GET['prenom']) . ' ' . strtoupper($_GET['nom']);
                                                                    } ?></h1>
                    <div class="inputs">
                        <input name="id" type="number" style="display: none;" value="<?php echo $_GET['id']; ?>">
                        <input name="nom" type="text" placeholder="Nom de l'utilisateur" value="<?php echo $_GET['nom']; ?>">
                        <input name="prenom" type="text" placeholder="Prénom de l'utilisateur" value="<?php echo $_GET['prenom']; ?>">
                        <input name="email" type="text" placeholder="Email de l'utilisateur" value="<?php echo $_GET['email']; ?>">
                        <input name="rang" type="text" placeholder="Rang de l'utilisateur" value="<?php echo $_GET['rang']; ?>">
                        <input name="formation" type="text" placeholder="Formation de l'utilisateur" value="<?php echo $_GET['formation']; ?>">
                        <button type="submit" name="userUpdateSubmit">Appliquer les modifications</button>
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
    <script src="../script/admin.js"></script>
</body>

</html>
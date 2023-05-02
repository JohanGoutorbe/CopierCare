<?php

//Affichage des erreurs sur la page web
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connexion à la base de données
include './dbconnect.php';
$message = '';

if (@isset($_SESSION['logged']) && @$_SESSION['logged'] == true) {
    $_SESSION['validate'] = true;
} else {
    $_SESSION['errors'] = "Veuillez vous authentifier à l'aide de l'une des méthodes ci-dessus.";
    header('Location: login.php');
    exit();
}

$sql = "SELECT * FROM `pieces` WHERE 1 ORDER BY id DESC";
$stmt = $db->prepare($sql);
$stmt->execute();

if (isset($_POST[('PieceSubmit')])) {
    if (!empty($_POST['pieceName']) && !empty($_POST['pieceRef'])) {
        $pieceName = htmlspecialchars($_POST['pieceName']);
        $pieceRef = htmlspecialchars($_POST['pieceRef']);
        if (strlen($pieceName) < 100 && strlen($pieceRef) < 20) {
            $Crud = 'C';
        } else {
            $message = "Le nom ou la référence de la pièce est trop long.";
        }
    }
}

if (isset($_POST['PieceDeleteSubmit'])) {
    $Crud = 'D';
}

if (isset($_POST['PieceUpdateSubmit'])) {
    $Crud = 'U1';
}

if (isset($_POST['PieceUpdate2Submit'])) {
    $Crud = 'U2';
    $pieceName = $_POST['pieceName'];
    $pieceRef = $_POST['pieceRef'];
    $pieceId = $_POST['pieceId'];
}

if (@$Crud != '0') {
    try {
        switch (@$Crud) {
            case 'C':
                $sql = "INSERT INTO `pieces` (`nom`, `ref`) VALUES (:name, :ref)";
                $stmt = $db->prepare($sql);
                $stmt->bindParam('name', $pieceName);
                $stmt->bindParam('ref', $pieceRef);
                $stmt->execute();
                $message = "Réussite de l'insertion.<br>La pièce " . $pieceName . " a bien été ajoutée.";
                break;
            case 'U2':
                $sql = "UPDATE `pieces` set nom = :name, ref = :ref WHERE id = :id";
                $stmt = $db->prepare($sql);
                $stmt->bindParam('name', $pieceName);
                $stmt->bindParam('ref', $pieceRef);
                $stmt->bindParam('id', $id);
                $stmt->execute();
                break;
            case 'D':
                # https://www.youtube.com/watch?v=2QPuo3ynS_U
                break;
        }
    } catch (\Throwable $th) {
        //throw $th;
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
    <link rel="stylesheet" href="./style/style.css">
    <link rel="shortcut icon" href="./getImage.php?nom=logo_copiercare.png" type="image/x-icon">
</head>

<body>
    <div class="container" style="grid-template-columns: 14rem auto 18rem;">
        <aside>
            <div class=" top">
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
                <button id="AddPieceBtn" class="AddPieceBtn">
                    <h2 style="text-align:left; font-size: 1.4rem; font-family: Poppins, sans-serif; color: #363949;">Ajouter une pièce</h2>
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
                <?php echo $message; ?>
            </div>
            <div class="alert bis">
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
                        while ($query = $stmt->fetch()) {
                            echo '<tr>';
                            echo '<td style="display: none;">' . $query['id'] . '</td>';
                            echo '<td>' . $query['nom'] . '</td>';
                            echo '<td>' . $query['ref'] . '</td>';
                            echo '<td class="warning" style="max-width: 100px;"><span class="material-icons-sharp">edit</span></td>';
                            echo '<td class="danger" style="max-width: 100px;"><span class="material-icons-sharp">delete</span></td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
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
    <script src="./pieces.js"></script>
</body>

</html>
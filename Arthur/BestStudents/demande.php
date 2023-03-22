<?php
session_start();
require_once "src/outils/utils.php";
require_once "src/modele/contactDB.php";
require_once "src/outils/ligneDemande.php";
if (!isset($_SESSION["id"])) {
    $_SESSION["id"] = [];
} else {
    $erreur = null;
}
if (empty($_SESSION["id"])){
    $erreur = "Vous n'avez pas les permissions pour voir ce contenu";
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["deco"])) {
        $_SESSION["id"] = [];
    } else if (isset($_POST["pseudo"])) {
    } else {
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../styleBestStudents/styleAccueil.css">
    <link rel="stylesheet" href="../styleBestStudents/styleDemande.css">
    <title>Demandes</title>
</head>
<body>
<div class="container">
    <?php
    include_once "src/outils/navigation.php";
    ?>
    <div class="containDemande">
        <?php
        if (isset($erreur)){
            echo $erreur;
        } else { ?>
        <div class="tableau">
            <div class="lines">
                <h3>ID</h3>
                <h3>NOM</h3>
                <h3>PRENOM</h3>
                <h3>EMAIL</h3>
                <h3>OBJET</h3>
                <h3>DATE</h3>
                <h3>ETAT</h3>
                <h3>PLUS</h3>
            </div>
            <?php
            if (getUserByIdUser($_SESSION["id"]) != 1){
                foreach (getContactForUser($_SESSION["id"])as $value) {
                    createNewLine($value["id_contact"]);
                }
            } else {
                foreach (getAllDemande() as $value) {
                    createNewLine($value["id_contact"]);
                }
            }
            ?>
        </div>
            <?php
        }
        ?>
    </div>
    <footer></footer>
</div>

</body>
</html>

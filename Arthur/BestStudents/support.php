<?php
session_start();
require_once "src/outils/utils.php";
require_once "src/modele/etudiantDB.php";
require_once "src/modele/contactDB.php";
$user = null;
if (!isset($_SESSION["id"])) {
    $_SESSION["id"] = [];
}
if (empty($_SESSION["id"])){
    $erreur = "Vous n'avez pas les permissions pour voir ce contenu";
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["deco"])) {
        $_SESSION["id"] = [];
    } else
        if (isset($_POST["pseudo"])) {
        } else {
            $user = getContactById($_POST["id"])[0];
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
    <link rel="stylesheet" href="styleBestStudents/styleAccueil.css">
    <link rel="stylesheet" href="styleBestStudents/styleDemande.css">
    <title>Demandes</title>
</head>
<body>

<div class="container">
    <?php
    include_once "src/outils/navigation.php";
    ?>
    <div class="containSupport">
        <div class="demande">
            <div class="objet">
                <h1><?= strtoupper($user["nom_contact"]) . " " . ucfirst($user["prenom_contact"]) ?></h1>
            </div>
            <div class="message">
                <p>Objet : <?= $user['objet_contact'] ?></p>
                <p><?= $user["message_contact"] ?></p>
            </div>
        </div>
        <div class="reponse">
            <div class="from">
                <p>From : <?= $user["email_contact"] ?></p>
            </div>
            <div class="to">

            </div>
            <div class="messageReponse">

            </div>
        </div>
    </div>

</div>
<footer></footer>
</div>


</body>
</html>
<?php
session_start();
require_once "src/modele/etudiantDB.php";
require_once "src/outils/utils.php";
require_once "src/outils/card.php";
$id = null;
$erreur = null;
if (!empty($id) || is_numeric($_GET["id"])) {
    $id = $_GET["id"];
} else {
    $erreur = "pu sa mèr";
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["deco"])) {
        $_SESSION["id"] = [];
    } else
        if (isset($_POST["pseudo"])) {
        } else {
        }
}
$promotionTableau = getAllPromotion();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
          integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="style.css">
    <title>Détails étudiant</title>
</head>
<body>
<header><img src="Logo.png" alt="logo" id="logo">
    <svg id="burger" viewBox="0 0 100 100" width="80"
         onclick="this.classList.toggle('active'); document.querySelector('header > ul').classList.toggle('click');">
        <path class="line top"
              d="m 30,33 h 40 c 3.722839,0 7.5,3.126468 7.5,8.578427 0,5.451959 -2.727029,8.421573 -7.5,8.421573 h -20"/>
        <path class="line middle" d="m 30,50 h 40"/>
        <path class="line bottom"
              d="m 70,67 h -40 c 0,0 -7.5,-0.802118 -7.5,-8.365747 0,-7.563629 7.5,-8.634253 7.5,-8.634253 h 20"/>
    </svg>
    <ul>
        <li><a href="index.php">Accueil</a></li>
        <li><a href="formulaire.php" target="_blank">Formulaire</a></li>
        <li><a href="contact.php">Contact</a></li>
    </ul>
</header>
<div class="containerFiche">
    <?php
    if (isset($erreur)) {
        echo $erreur;
    } else {
        $etudiant = getStudentbyId($id)[0];
        if ($etudiant["photo_etudiant"] != null) {
            echo "<img src= imageEtudiant/" . $etudiant["photo_etudiant"] . " alt=\"\" class='imageEtudiant'>";
        } else if ($etudiant["Sexe"] == "M") {
            echo "<img src=\"gars.png\" alt=\"\" class='imageEtudiant'>";
        } else {
            echo "<img src=\"fille.png\" alt=\"\" class='imageEtudiant'>";
        }
        echo "<h1>" . $etudiant["prenom_etudiant"] . " " . $etudiant["nom_etudiant"] . "</h1><div class='information'>
<p>Email :</p>
<p>" . $etudiant["email_etudiant"] . "</p>
<p>Date de naissance :</p>
<p>" . reformatDate($etudiant["date_naissance_etudiant"]) . "</p>
<p>Age :</p>";
        if (calculerAge($etudiant["date_naissance_etudiant"]) >= 18) {
            echo "<p><span class=\"green\">" . calculerAge($etudiant["date_naissance_etudiant"]) . " ans</span></p>";
        } else {
            echo "<p><span class=\"red\">" . calculerAge($etudiant["date_naissance_etudiant"]) . " ans</span></p>";
        }
        echo "

<p>Adresse :</p>
<p>" . $etudiant["adresse_etudiant"] . "</p>
<p>Numéro de téléphone :</p>
<p>" . $etudiant["telephone_etudiant"] . "</p>
<p>Sexe :</p><p>" . $etudiant["Sexe"] . "</p>
<p>Promotion :</p>";
        if ($etudiant["id_promotion"] === 0) {
            echo "<p>Pas de promotion</p>";
        } else {
            echo $promotionTableau[$etudiant["id_promotion"]];
        }
        echo "
</div></div>";


    }
    ?>
    <footer></footer>
</div>
</body>
</html>


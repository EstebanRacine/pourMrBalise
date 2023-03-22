<?php
session_start();
include_once "src/outils/utils.php";
require_once "src/modele/contactDB.php";
require_once "src/modele/horaireDB.php";
require_once "src/modele/userDB.php";
$horaire = getHoraire();
$green = false;
$prenom = null;
$nom = null;
$email = null;
$message = null;
$objet = null;
$objetEmetteur = "=?utf-8?B?" . base64_encode("Votre demande a été prise en compte") . "?=";
$messageEmetteur = "Nous traiterons votre demande d'ici peu";
$entete = [
    "from" => "contact@beststudents.com",
    "content-type" => "text/plain; charset=UTF-8",
    "Cc" => "moi@gmail.com"
];
if (!isset($_SESSION["id"])) {
    $_SESSION["id"] = [];
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["deco"])) {
        $_SESSION["id"] = [];
    } else
        if (isset($_POST["pseudo"])) {
        } else {
            /*test des champs obligatoires*/
            if (empty(trim($_POST["prenom"]))) {
                $erreurs["prenom"] = "Le prenom est obligatoire";
            } else {
                $prenom = $_POST["prenom"];
            }
            if (empty(trim($_POST["objet"]))) {
                $erreurs["objet"] = "L'objet est obligatoire";
            } else {
                $objet = $_POST["objet"];
            }


            if (empty(trim($_POST["nom"]))) {
                $erreurs["nom"] = "Le nom est obligatoire";
            } else {
                $nom = $_POST["nom"];
            }


            if (empty(trim($_POST["email"]))) {
                $erreurs["email"] = "L'email est obligatoire";
            } else if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $erreurs["email"] = "Email incorrect";
            } else {
                $email = $_POST["email"];
                $emetteur = $email;
            }

            if (empty(trim($_POST["message"]))) {
                $erreurs["message"] = "Le message est obligatoire";
            } else {
                $message = $_POST["message"];
            }
            if (!isset($erreurs)) {
                if (mail($emetteur, $objetEmetteur, $messageEmetteur, $entete)) {
                    addContact($nom, $prenom, $email, $objet, $message);
                    $prenom = null;
                    $nom = null;
                    $email = null;
                    $message = null;
                    $objet = null;
                } else {
                    $erreurs["envoiMail"] = "Echec de l'envoi du mail";
                }
            }
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
    <link rel="stylesheet" href="styleBestStudents/styleContact.css">
    <title>Contact</title>
</head>
<body>
<div class="container">
    <?php
    include_once "src/outils/navigation.php";
    ?>
    <div class="containContact">
        <div class="informations">
            <p>Numéro de téléphone :</p>
            <p>+33 3 81 54 77 77
                <?php
                if (!checkDisponibiliteSecretariat()) {
                    echo "<br><span class='red'>Ne répondra pas</span>";
                }
                ?>
            </p>
            <p>Adresse mail : </p>
            <a href="mailto:XavierDuPontDeLigonnes@gmail.com">XavierDuPontDeLigonnes@gmail.com</a>
            <p>Adresse :</p><a href="https://goo.gl/maps/FKuREBV9QERaNywp9">V4XQ+5X7, Sarfannguit, Groenland</a>
            <div class="carte">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1316.3922624815525!2d-52.86046299011315!3d66.89829467532019!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4e91032d10ebcd2d%3A0x3448038b619eb4fc!2sSarfannguit!5e0!3m2!1sfr!2sfr!4v1677677501241!5m2!1sfr!2sfr"
                        width="400" height="300" style="border:0;" allowfullscreen="true" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <img src="imageWeb/ecole.jpg" alt="ecole">
        </div>
        <div class="formulaireContact">
            <form class="formulaire" action="" method="post" enctype="multipart/form-data">
                <label for="prenom">Prenom *</label>
                <input type="text" id="prenom" name="prenom" value="<?= $prenom ?>">
                <?php
                if (isset($erreurs["prenom"])) { ?>
                    <p class="erreur"> <?= $erreurs["prenom"] ?></p><br>
                <?php } ?>
                <label for="nom">Nom *</label>
                <input type="text" id="nom" name="nom" value="<?= $nom ?>">
                <?php
                if (isset($erreurs["nom"])) { ?>
                    <p class="erreur"> <?= $erreurs["nom"] ?></p><br>
                <?php } ?>


                <label for="email">Email *</label>
                <input type="text" id="email" name="email" value="<?= $email ?>">
                <?php
                if (isset($erreurs["email"])) { ?>
                    <p class="erreur"> <?= $erreurs["email"] ?></p><br>
                <?php } ?>
                <label for="objet">Objet *</label>
                <input type="text" id="objet" name="objet" value="<?= $objet ?>">
                <?php
                if (isset($erreurs["objet"])) { ?>
                    <p class="erreur"> <?= $erreurs["objet"] ?></p><br>
                <?php } ?>

                <label for="message">Message *</label>
                <textarea name="message" id="message"></textarea>
                <?php
                if (isset($erreurs["message"])) { ?>
                    <p class="erreur"> <?= $erreurs["message"] ?></p><br>
                <?php } ?>
                <input type="submit" value="Envoyer" id="send">
                <?php
                if (isset($erreurs["envoiMail"])) { ?>
                    <p class="erreur"> <?= $erreurs["envoiMail"] ?></p><br>
                <?php } ?>

            </form>
        </div>
        <h1>Planning</h1>
        <div class="planning">
            <?php
            foreach ($horaire as $value) {
                echo "
<div class='horaire'>
<p>" . getDay($value["id_jour"]) . "</p>
<p>" . $value["ouvertureMatin"] . " - " . $value["fermetureMatin"] . "</p>
<p>" . $value["ouvertureApresMidi"] . " - " . $value["fermetureApresMidi"] . "</p>
</div>";
            }
            ?>
        </div>
        <?php
        if (checkDisponibiliteSecretariat()) {
            echo "<span class = 'green'>Le secrétariat est disponnible</span>";
        } else {
            echo "<span class = 'red'>Le secrétariat n'est pas disponnible</span>";
        }
        ?>
    </div>
    <footer></footer>
</div>
</body>
</html>

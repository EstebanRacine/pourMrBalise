<?php
session_start();
require_once "src/outils/utils.php";
require_once "src/modele/etudiantDB.php";
require_once "src/modele/promotionDB.php";
$prenom = null;
$nom = null;
$email = null;
$dateNaissance = null;
$adresse = null;
$telephone = null;
$sexe = null;
$photo = null;
$promotion = null;
$tableauPromotion = getAllPromotion();
$erreurs = [];

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
            }


            if (empty(trim($_POST["date-naissance"]))) {
                $erreurs["dateNaissance"] = "La date de naissance est obligatoire";
            } else {
                $dateNaissance = $_POST["date-naissance"];
            }


            if (empty(trim($_POST["adresse"]))) {
                $erreurs["adresse"] = "L'adresse' est obligatoire";
            } else {
                $adresse = $_POST["adresse"];
            }


            if (empty(trim($_POST["telephone"]))) {
                $erreurs["telephone"] = "Le numéro de téléphone est obligatoire";
            } else if (!is_numeric($_POST["telephone"]) || strlen($_POST["telephone"]) > 12) {
                $erreurs["telephone"] = "Le numéro de téléphone est invalide";
            } else {
                $telephone = $_POST["telephone"];
            }

            if (empty($_POST["sexe"])) {
                $erreurs["sexe"] = "Un nouveau sexe wtf ????";
            } else {
                $sexe = $_POST["sexe"];
            }

            if (empty($_FILES["photo"]["size"])) {
                $erreurs["photo"] = "La photo est obligatoire";
            } else {
                $nomFichier = $_FILES["photo"]["name"];
                $typeFichier = $_FILES["photo"]["type"];
                $tmpFichier = $_FILES["photo"]["tmp_name"];
                $tailleFichier = $_FILES["photo"]["size"];
                if (!str_contains($typeFichier, "image")) {
                    $erreurs["photo"] = "Ce n'est pas une image";
                } else if ($tailleFichier > 4800000) {
                    $erreurs ["photo"] = "image trop volumineux";
                } else {
                    //récupérer l'extension de fichier
                    $extensionFichier = pathinfo($_FILES["photo"]["name"], 4);

                    //générer un nom de fichier unique
                    $nomFichier = uniqid() . "." . $extensionFichier;

                    //deplacer le fichier dans le dossier image
                    if (!move_uploaded_file($tmpFichier, "imageEtudiant/$nomFichier")) {
                        $erreurs["photo"] = "erreur de l'upload";
                    }
                }
            }
            $promotion = $_POST["promotion"];
            if (empty($erreurs)) {
                addStudent($prenom, $nom, $email, $dateNaissance, $adresse, $telephone, $sexe, $nomFichier, $promotion);
                header("Location: index.php");
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
    <title>Formulaire</title>
</head>
<body>
<div class="container">
    <?php
    include_once "src/outils/navigation.php"
    ?>

    <div class="containerFormulaire">
        <h1>Ajouter un étudiant</h1>
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


            <label for="date-naissance">Date de naissance *</label>
            <input type="date" id="date-naissance" name="date-naissance" value="<?= $dateNaissance ?>">
            <?php
            if (isset($erreurs["dateNaissance"])) { ?>
                <p class="erreur"> <?= $erreurs["dateNaissance"] ?></p><br>
            <?php } ?>

            <label for="adresse">Adresse *</label>
            <input type="text" id="adresse" name="adresse" value="<?= $adresse ?>">
            <?php
            if (isset($erreurs["adresse"])) { ?>
                <p class="erreur"> <?= $erreurs["adresse"] ?></p><br>
            <?php } ?>


            <label for="telephone">Telephone *</label>
            <input type="tel" id="telephone" name="telephone" value="<?= $telephone ?>">
            <?php
            if (isset($erreurs["telephone"])) { ?>
                <p class="erreur"> <?= $erreurs["telephone"] ?></p><br>
            <?php } ?>


            <label for="sexe">Sexe *</label>
            <select id="sexe" name="sexe">
                <option value=""></option>
                <option value="homme">Homme</option>
                <option value="femme">Femme</option>
                <option value="autre">Autre</option>
                <option value="char d'assaut A41 Centurion">Char d'assaut A41 Centurion</option>
            </select>
            <?php
            if (isset($erreurs["sexe"])) { ?>
                <p class="erreur"> <?= $erreurs["sexe"] ?></p>
            <?php } ?>
            <br>

            <label for="promotion">Promotion</label>
            <select id="promotion" name="promotion">
                <option value="">Aucun</option>
                <?php
                foreach ($tableauPromotion as $key => $value) {
                    echo "<option value=\"" . $key . "\">" . $value . "</option>";
                }
                ?>
            </select><br><br>


            <label for="photo">Photo *</label>
            <input type="file" name="photo" id="photo">
            <?php
            if (isset($erreurs["photo"])) { ?>
                <p class="erreur"> <?= $erreurs["photo"] ?></p><br>
            <?php } ?>


            <p>* : Champ obligatoire</p>
            <input type="submit" value="Envoyer">

        </form>
        <footer></footer>
    </div>
</div>
</body>
</html>

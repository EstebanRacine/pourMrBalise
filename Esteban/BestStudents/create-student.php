<?php
include "src/utils/requetes.php";


$prenom = NULL;
$nom = NULL;
$date_naissance=NULL;
$email = NULL;
$tel = NULL;
$adresse = NULL;
$ville = NULL;
$image = NULL;
$erreurs = [];

$listePromo = getAllPromo();

if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(empty(trim($_POST['prenom']))){
        $erreurs['prenom'] = "Veuillez remplir le champs Prénom";
    } else{
        $prenom = $_POST['prenom'];
    }

    if(empty(trim($_POST['nom']))){
        $erreurs['nom'] = "Veuillez remplir lez champs Nom";
    } else{
        $nom = $_POST['nom'];
    }

    if (empty(trim($_POST['date_naissance']))){
        $erreurs['date_naissance'] = "Veuillez remplir le champs Date de naissance";
    } else{
        $date_naissance = $_POST['date_naissance'];
    }

    if (empty(trim($_POST['email']))){
        $erreurs['email'] = "Veuillez remplir le champs Email";
    }else{
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $erreurs['email'] = "L'email n'est pas valide";
        }
        $email = $_POST['email'];
    }


    if(empty(trim($_POST['tel']))){
        $erreurs['tel'] = "Veuillez remplir le champs Telephone";
    }else{
        $tel = $_POST['tel'];
    }

    if (isset($_POST['adresse'])){
        $adresse = $_POST['adresse'];
    }

    if (empty(trim($_POST['ville']))){
        $erreurs['ville'] = "Veuillez remplir le champs Ville";
    }else{
        $ville = $_POST['ville'];
    }
    if (empty($erreurs)) {
        if (empty($_FILES["image"]['name'])) {
            $image = "src/images/students/student.jpg";
        } else {
            $nomFichier = $_FILES["image"]['name'];
            $typeFichier = $_FILES["image"]['type'];
            $tmpFichier = $_FILES["image"]['tmp_name'];
            $tailleFichier = $_FILES["image"]['size'];
            if (!str_contains($typeFichier, "image")) {
                $erreurs['image'] = "Le fichier n'est pas une image";
            } else {
                if ($tailleFichier > 600000) {
                    $erreurs['image'] = "L'image est trop lourde";
                } else {
                    $extensionFichier = pathinfo($nomFichier, 4);
                    print_r($extensionFichier);
                    if ($extensionFichier != "png" and $extensionFichier != "jpg" and $extensionFichier != "jepg" and $extensionFichier != "JPEG" and $extensionFichier != "JPG" and $extensionFichier != "PNG") {
                        $erreurs['image'] = "Le fichier n'a pas la bonne extension (png, jpg ou jpeg)";
                    } else {
                        $nomFichier = uniqid() . "." . $extensionFichier;
                        $image = "src/images/students/$nomFichier";
                        if (!move_uploaded_file($tmpFichier, "src/images/students/$nomFichier")){
                            $erreurs['image'] = "Erreur lors de l'upload";
                        }else{
                            move_uploaded_file($tmpFichier, "src/images/students/$nomFichier");
                        }
                    }
                }
            }
        }
    }

    if(empty($erreurs)){
        $promoEtudiant = $_POST['promo'];
        addStudent($prenom, $nom, $date_naissance, $email, $tel, $adresse, $ville, $image, $promoEtudiant);
        header('Location: index.php');
    }

}


?>



<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Accueil</title>
</head>
<body>
<div class="container">
    <?php
    include "src/headerEtNav.php";
    ?>

    <main class="creation">
        <form action="" method="post" enctype="multipart/form-data">

            <label for="prenom">Prénom <span class="Rouge">*</span></label>
            <input type="text" name="prenom" id="prenom" value="<?= $prenom ?>">
            <?php
            if (isset($erreurs['prenom'])){
                $erreur = $erreurs['prenom'];
                echo "<p class='Rouge'> $erreur </p>";
            }else{
                echo "<p> </p>";
            }
            ?>

            <label for="nom">Nom <span class="Rouge">*</span></label>
            <input type="text" name="nom" id="nom" value="<?= $nom ?>">
            <?php
            if (isset($erreurs['nom'])){
                $erreur = $erreurs['nom'];
                echo "<p class='Rouge'> $erreur </p>";
            }else{
                echo "<p> </p>";
            }
            ?>

            <label for="date_naissance">Date de naissance <span class="Rouge">*</span></label>
            <input type="date" name="date_naissance" id="date_naissance" value="<?= $date_naissance ?>">
            <?php
            if (isset($erreurs['date_naissance'])){
                $erreur = $erreurs['date_naissance'];
                echo "<p class='Rouge'> $erreur </p>";
            }else{
                echo "<p> </p>";
            }
            ?>

            <label for="email">Email <span class="Rouge">*</span></label>
            <input type="text" name="email" id="email" value="<?= $email ?>">
            <?php
            if (isset($erreurs['email'])){
                $erreur = $erreurs['email'];
                echo "<p class='Rouge'> $erreur </p>";
            }else{
                echo "<p> </p>";
            }
            ?>

            <label for="tel">Telephone <span class="Rouge">*</span></label>
            <input type="text" name="tel" id="tel" value="<?= $tel ?>"">

            <?php
            if (isset($erreurs['tel'])){
                $erreur = $erreurs['tel'];
                echo "<p class='Rouge'> $erreur </p>";
            }else{
                echo "<p> </p>";
            }
            ?>

            <label for="adresse">Adresse</label>
            <input type="text" name="adresse" id="adresse" value="<?= $adresse ?>"">
            <br>


            <label for="ville">Ville <span class="Rouge">*</span></label>
            <input type="text" name="ville" id="ville" value="<?= $ville ?>">
            <?php
            if (isset($erreurs['ville'])){
                $erreur = $erreurs['ville'];
                echo "<p class='Rouge'> $erreur </p>";
            }else{
                echo "<p> </p>";
            }
            ?>

            <label for="promo">Promotion</label>
            <select name="promo" id="promo">
                <option value="">Aucune promotion</option>
                <?php
                foreach($listePromo as $promo){
                    echo "<option value=".$promo['id_promo'].">".$promo['nom_promo']."</option>";
                }
                ?>

            </select>



            <label for="image">Image <span class="Rouge">**</span></label>
            <input type="file" name="image" id="image" class="inputImage">
            <?php
            if (isset($erreurs['image'])){
                $erreur = $erreurs['image'];
                echo "<p class='Rouge'> $erreur </p>";
            }else{
                echo "<p> </p>";
            }
            ?>

            <input type="submit" value="Envoyer" class="submit">

        </form>

        <div id="stars">
            <p>(<span class="Rouge">*</span> : Les astérisques signifient que le champ est obligatoire)</p>
            <p>(<span class="Rouge">**</span> : Si aucune image n'a été donnée une image de base sera attribuée )</p>
        </div>


    </main>

    <?php
    include "src/footer.php";
    ?>

</div>
</body>
</html>
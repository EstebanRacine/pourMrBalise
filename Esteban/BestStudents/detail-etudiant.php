<?php
include "src/utils/requetes.php";
include "src/utils/date.php";
include "src/utils/fonctions.php";

$etudiantID = $_GET['id'];
$etudiant = getStudentByID($etudiantID)[0];
$nom = strtoupper($etudiant['nom']);
$prenom = ucfirst($etudiant['prenom']);
$img = $etudiant['img'];
$date_naissance = writeBirthLetter($etudiant['date_naissance']);
$email = $etudiant['email'];
$tel = $etudiant['tel'];
$adresse = $etudiant['adresse'];
$ville = strtoupper($etudiant['ville']);
$age = getAge($etudiant['date_naissance']);
if(isset(getPromoNameById($etudiant['promo_etudiant'])['nom_promo'])){
    $promo = getPromoNameById($etudiant['promo_etudiant'])['nom_promo'];
}else{
    $promo = "Cet étudiant n'a pas de promotion";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Accueil</title>
</head>
<body>
<div class="container">
    <?php
    include "src/headerEtNav.php";
    ?>

    <main>
        <div class="details">
            <img src="<?= $img ?>" alt="Image de l'étudiant">
            <div class="nomDetail">
                <p><?= $prenom." ".$nom ?></p>
            </div>
            <div class="birthDetail">
                <p> <i class="fa-solid fa-cake-candles"></i> <?= " ".$date_naissance ?></p>
                <?php
                if ($age < 18){
                    echo "<p class='Rouge'> $age ans </p>";
                }else{
                    echo "<p class='Vert'> $age ans </p>";
                }
                ?>
            </div>
            <div class="adresseDetails">
                <i class="fa-solid fa-house"></i>
                <p><?= $adresse?></p>
                <p><?= $ville?></p>
            </div>
            <div class="promotionEtudiant">
                <i class="fa-solid fa-graduation-cap"></i>
                <p><?= $promo ?></p>

            </div>
            <div class="contactDetails">
                <h2>CONTACT</h2>
            </div>
            <div class="mailDetails">
                <i class="fa-solid fa-envelope"></i>
                <p><?= $email ?></p>
            </div>
            <div class="telDetails">
                <i class="fa-solid fa-phone"></i>
                <p><?= $tel ?></p>
            </div>
        </div>

    </main>

    <?php
    include "src/footer.php";
    ?>

</div>
</body>
</html>
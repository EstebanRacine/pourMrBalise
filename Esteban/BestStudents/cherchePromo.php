<?php
include "src/utils/requetes.php";
include "src/utils/date.php";
include "src/utils/fonctions.php";

if($_SERVER['REQUEST_METHOD']=="POST"){
    $id = $_POST['id'];
    $arrayStudents = getStudentsInPromo($id);
}else{
$arrayStudents = getAllStudents();
}

$listePromos = getAllPromo();

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

    <form action="" method="post" enctype="multipart/form-data" class="recherche">
        <select name="id" id="id">
            <?php
            foreach ($listePromos as $promo){
                echo "<option value=".$promo['id_promo'].">".$promo['nom_promo']."</option>";
            }
            ?>
        </select>
        <input type="submit" value="Rechercher">
    </form>


    <main class="index">
        <?php
        foreach($arrayStudents as $etudiant){
            ?>
            <div class="card">
                <img src="<?= $etudiant['img'] ?>" alt="Image de l'étudiant">
                <div class="nomIndex">
                    <p><?= ucfirst($etudiant['prenom']) . " " .strtoupper($etudiant['nom'])?></p>
                </div>
                <div class="birthIndex">
                    <p><?= writeBirthNumber($etudiant['date_naissance'])?></p>
                </div>
                <div class="ageIndex">
                    <?php
                    $age = getAge($etudiant['date_naissance']);
                    if ($age >= 18){
                        echo "<p class='Vert'>$age ans</p>";
                    }else{
                        echo "<p class='Rouge'>$age ans</p>";
                    }
                    ?>
                </div>
                <div class="buttonVoir">
                    <a href="detail-etudiant.php?id=<?= $etudiant['id']?>">Voir Détails</a>
                </div>

            </div>


        <?php } ?>

    </main>

    <?php
    include "src/footer.php";
    ?>

</div>
</body>
</html>

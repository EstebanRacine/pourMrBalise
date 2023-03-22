<?php
include_once "src/utils/date.php";
include_once "src/utils/requetes.php";
include_once "src/utils/fonctions.php";



$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD']=="POST"){
    if (isset($_POST['retour'])){
        header("Location: gestionDemandes.php");
    }else {
        traiterContact($id);
    }
}

$demande = getContactById($id);
$nom = $demande['nomContact'];
$prenom = $demande['prenomContact'];
$mail = $demande['mailContact'];
$objet = $demande['objetContact'];
$message = $demande['messageContact'];
$datetime = $demande['datetimeContact'];
if ($demande['traitementContact'] == 0){
    $etat = "<p class='Rouge'>Non traitée</p>";
}else{
    $etat = "<p class='Vert'>Traitée</p>";
}

$date = substr($datetime, 0, 10);
$date = substr($date, -2)."/".substr($date, 5, 2)."/".substr($date, 0, 4);
$heure = substr($datetime, 11);

?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Demande</title>
</head>
<body>
<div class="container">
    <?php
    include "src/headerEtNav.php";
    ?>

    <div class="demandeUnique">
        <h1>Demande de <?= $nom." ".$prenom?></h1>
        <h2><?= "Le ".$date." à ".$heure ?></h2>
        <h3><?= "Objet : ".$objet ?></h3>
        <p><?= $message ?></p>
        <?= $etat ?>
        <form action="" method="post">
            <input type="submit" value="Demande traitée">
        </form>

        <form action="" method="post">
<!--            <input hidden type="text" name="login" value="">-->
<!--            <input hidden type="text" name="mdp" value="">-->
            <button name="retour" value="1" id="retourDemande">Retour</button>
        </form>

    </div>




    <?php
    include "src/footer.php";
    ?>
</div>


</body>
</html>

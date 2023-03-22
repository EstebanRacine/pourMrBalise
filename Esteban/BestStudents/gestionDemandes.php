<?php
include_once "src/utils/date.php";
include_once "src/utils/requetes.php";
include_once "src/utils/fonctions.php";
session_start();

$acces = "Non connecté";

if (!isset($_SESSION['user'])){
    $_SESSION['user']=[];
}

if (!isset($_SESSION['user']['isCo'])){
    $_SESSION['user']['isCo'] = False;
}else{
    $demandes = getAllContact();
}

if ($_SERVER['REQUEST_METHOD']=="POST") {
    if (isset($_POST['deco'])) {
        $_SESSION['user']['isCo'] = False;
    } else {
        if (!$_SESSION['user']['isCo']) {
            $login = $_POST['login'];
            $mdp = $_POST['mdp'];
            $acces = verifUser($login, $mdp);
        }
        $demandes = getAllContact();
        if (isset($_POST['traitement'])) {
            $traitement = $_POST['traitement'];
            if ($traitement == 0) {
                $demandes = getContactNonTraites();
            } elseif ($traitement == 1) {
                $demandes = getContactTraites();
            }
        }
        if (gettype($acces) == "boolean") {
            $_SESSION['user']['isCo'] = true;
        }
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Gestion des demandes</title>
</head>
<body>
<div class="container">
    <?php
    include "src/headerEtNav.php";
    ?>

    <?php
    if (!$_SESSION['user']['isCo']){?>
        <div class="connexionGestion">
            <form action="" method="post" class="formConnexionGestion" autocomplete="off">
                <div class="center">
                <label for="login">Login</label>
                <input type="text" name="login" id="login">
                    <span class="barre"></span>
                </div>
                <div class="center">
                <label for="mdp">Mot de passe</label>
                <input type="password" id="mdp" name="mdp">
                    <span class="barre"></span>
                <input type="submit" value="Se connecter" id="connexionSubmitGestion">
                    <?php
                    if ($_SERVER['REQUEST_METHOD']=="POST"){
                        echo "<p class='Rouge'>$acces</p>";
                    }
                    ?>
                </div>
            </form>
        </div>


        <?php
        }else{
        ?>
        <div class="listeDemandes">
            <form action="" method="post">
<!--                <input hidden type="text" value="--><?//= $_POST['login']?><!--" name="login">-->
<!--                <input hidden type="password" value="--><?//= $_POST['mdp']?><!--" name="mdp">-->
                <select name="traitement" id="traitement">
                    <option value="">Toutes les demandes</option>
                    <option value="0">Demande non traitées</option>
                    <option value="1">Demandes traitées</option>
                </select>
                <input type="submit" id="submitFormDemande" value="Rechercher">
            </form>


            <div class="ligneDemande nomColonnesDemandes">
                <h3>ID</h3>
                <h3>NOM</h3>
                <h3>PRENOM</h3>
                <h3>OBJET</h3>
                <h3>MESSAGE</h3>
                <h3>ETAT</h3>
            </div>
            <?php

            foreach ($demandes as $demande){
                $id = $demande['idContact'];
                $nom = $demande['nomContact'];
                $prenom = $demande['prenomContact'];
                $objet = $demande['objetContact'];
                $message = $demande['messageContact'];
                if(strlen($message)>50){
                    $message = substr($message, 0, 48)."..";
                }

                if ($demande['traitementContact'] == 0){
                    $traitement = "<p class='Rouge'>Non traitée</p>";
                }else{
                    $traitement = "<p class='Vert'>Traitée</p>";
                }
                ?>

            <div class="ligneDemande">
                <p><?= $id ?></p>
                <p><?= $nom ?></p>
                <p><?= $prenom ?></p>
                <p><?= $objet ?></p>
                <p><?= $message ?></p>
                <?= $traitement ?>
                <a href="details-demande.php?id=<?= $id ?>">Voir plus</a>
            </div>



                <?php
                }
                ?>
            <form action="" method="post">
                <button type="submit" value="1" name="deco" id="deco">Se déconnecter</button>
            </form>

        </div>


    <?php
    }
    include "src/footer.php";
    ?>
</div>
</body>
</html>

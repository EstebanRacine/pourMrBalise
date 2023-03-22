<?php
session_start();
require_once "src/modele/etudiantDB.php";
require_once "src/modele/promotionDB.php";
require_once "src/outils/card.php";
require_once "src/outils/utils.php";
require_once "src/modele/connexionDB.php";

if (!isset($_SESSION["id"])) {
    $_SESSION["id"] = [];
}

$id = null;
$tableauPromotion = getAllPromotion();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["deco"])){
        $_SESSION["id"] = [];
    }else
    if (isset($_POST["pseudo"])) {
    } else {
        if (!empty($_POST["filtre"])) {
            $id = $_POST["filtre"];
        }
        if (isset($_POST["search"])) {
            $_POST["search"] = htmlspecialchars($_POST["search"]); //pour sécuriser le formulaire contre les intrusions html
            $terme = $_POST["search"];
            $terme = trim($terme); //pour supprimer les espaces dans la requête de l'internaute
            $terme = strip_tags($terme); //pour supprimer les balises html dans la requête

            if (isset($terme)) {
                $connexion = getConnexion();
                $terme = strtolower($terme);
                $select_terme = $connexion->prepare("SELECT * FROM db_etudiants.etudiant inner join db_etudiants.promotion on etudiant.id_promotion = promotion.id_promotion WHERE etudiant.prenom_etudiant LIKE ? or etudiant.nom_etudiant LIKE ?  or promotion.libellé_promotion LIKE ?");
                $select_terme->execute(array("%" . $terme . "%", "%" . $terme . "%", "%" . $terme . "%"));
                $resultat = $select_terme->fetchall(2);
            }
        }
    }
}
/*faire un planning des horraires et mettre en surbrillance le jour actuel*/
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF - 8">
    <meta name="viewport"
          content="width = device - width, user - scalable = no, initial - scale = 1.0, maximum - scale = 1.0, minimum - scale = 1.0">
    <meta http-equiv="X-UA-Compatible" content="ie = edge">
    <link rel="stylesheet" href="styleBestStudents/styleAccueil.css">
    <title>Best Students</title>
</head>
<body>
<div class="container">
    <?php
    include_once "src/outils/navigation.php";
    ?>
    <div class="filtre">
        <form action="" method="post" enctype="multipart/form-data" class="research form">
            <label for="search">
                <input required="" name="search" autocomplete="off" placeholder="search your chats" id="search"
                       type="text">
                <div class="icon">
                    <svg stroke-width="2" stroke="currentColor" viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg" class="swap-on">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linejoin="round"
                              stroke-linecap="round"></path>
                    </svg>
                    <svg stroke-width="2" stroke="currentColor" viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg" class="swap-off">
                        <path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-linejoin="round" stroke-linecap="round"></path>
                    </svg>
                </div>
                <button type="reset" class="close-btn">
                    <svg viewBox="0 0 20 20" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd"
                              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                              fill-rule="evenodd"></path>
                    </svg>
                </button>
            </label>
    </div>
    </form>
    <div class="contain">
        <?php
        if (isset($id)) {
            foreach (getAllStudents() as $value) {
                if ($value["id_promotion"] == $id) {
                    card($value);
                }
            }
        } else if (isset($resultat)) {
            foreach ($resultat as $value) {
                card($value);
            }
        } else {
            foreach (getAllStudents() as $value) {
                card($value);
            }
        }
        ?></div>
    <footer></footer>
</div>
</body>
</html>

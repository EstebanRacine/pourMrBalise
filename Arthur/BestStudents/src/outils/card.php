<?php
require_once "utils.php";
function card($etudiant): void
{
    echo "<div class=\"card\">
    <div class=\"head\">";
    if ($etudiant["photo_etudiant"] != null) {
        echo "<img src= imageEtudiant/" . $etudiant["photo_etudiant"] . " alt=\"\"></div>";
    } else if ($etudiant["Sexe"] == "M") {
        echo "<img src=\"imageWeb/gars.png\" alt=\"\"></div>";
    } else {
        echo "<img src=\"imageWeb/fille.png\" alt=\"\"></div>";
    }
    echo "
    <div class=\"prenom\"><p>" . $etudiant["prenom_etudiant"] . " " . $etudiant["nom_etudiant"] . "</p></div>
        <div class='descriptif'><p>
            " . reformatDate($etudiant["date_naissance_etudiant"])."</p>";
    if (calculerAge($etudiant["date_naissance_etudiant"]) >= 18) {
        echo "<span class=\"green\">" . calculerAge($etudiant["date_naissance_etudiant"]) . " ans<br><br></span>";
    } else {
        echo "<span class=\"red\">" . calculerAge($etudiant["date_naissance_etudiant"]) . " ans<br><br>";
    }
    echo "
</div>
    <a target=\"_blank\" href=\"ficheEtudiant.php?id=" . $etudiant["id_etudiant"] . "\">Plus d'information</a>
</div>";
}

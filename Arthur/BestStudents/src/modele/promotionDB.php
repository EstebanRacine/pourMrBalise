<?php
require_once "connexionDB.php";
function getStudentByIdPromotion($id): array|string
{
    $requete = getConnexion()->prepare("Select * from etudiant where id_promotion = :id");
    $requete->bindValue(":id", $id);
    $requete->execute();
    return $requete->fetchAll(2);
}
function getAllPromotion(): array
{
    $promotion = requeteSQL("select * from promotion");
    foreach ($promotion as $value) {
        $promotionTableau[$value["id_promotion"]] = $value["libellé_promotion"];
    }
    return $promotionTableau;
}

function getPromoById(int $id): array|string
{
    $connexion = getConnexion();
    $requeteSQL = "select * from etudiant where id_promotion = :id";
    $requete = $connexion->prepare($requeteSQL);
    $requete->bindValue(":id", $id);
    return $requete->fetchAll(2);
}

<?php
require_once "connexionDB.php";


function getAllStudents(): array|string
{
    $etudiants = requeteSQL("SELECT * FROM db_etudiants.etudiant");
    if (!empty($etudiants)) {
        return $etudiants;
    } else {
        return "Tableau vide";
    }
}

function getStudentbyId($id): array|string
{
    $requete = getConnexion()->prepare("Select * from db_etudiants.etudiant where id_etudiant = :id");
    $requete->bindValue(":id", $id);
    $requete->execute();
    return $requete->fetchAll(2);
}

//Requete avec arguements
function requeteSQLbis($requetesql)
{
    $requete = getConnexion()->prepare($requetesql);
    $arguments = func_get_args();
    $vraiOccurence = substr_count($requetesql, ":");
    $occurence = strpos($requetesql, ":");
    if (count($arguments) - 1 != $vraiOccurence) {
        return "nombre d'arguments != nombre de paramètres";
    }
    if (func_num_args() > 1) {
        $check = true;
        $mot = "";
        $max = substr_count($requetesql, ":");
        for ($i = 1; $i <= $max; $i++) {
            while ($check == true) {
                if ($requetesql[$occurence] == "," or $requetesql[$occurence] == " " or $requetesql[$occurence] == ")") {
                    $requete->bindValue($mot, $arguments[$i]);
                    $mot = "";
                    if (!$i == $max + 1) {
                        $occurence = strpos($requetesql, ":", $occurence + 1);
                    }
                    $check = false;
                } else {
                    $mot .= $requetesql[$occurence];
                }
                $occurence += 1;
            }
            $check = true;
        }
    }
    if (str_contains(strtolower($requetesql), "select")) {
        $requete->execute();
        return $requete->fetchAll(2);
    } else {
        return $requete->execute();
    }

}

function addStudent(string $prenom, string $nom, string $email, string $date, string $adresse, string $telephone, string $sexe, string $photo, int $id_promotion): bool
{
    $connexion = getConnexion();
    $requeteSQL = "Insert into db_etudiants.etudiant (prenom_etudiant,nom_etudiant,email_etudiant,date_naissance_etudiant,adresse_etudiant,telephone_etudiant,Sexe,photo_etudiant,id_promotion)
values(:prenom,:nom,:email,:date,:adresse,:telephone,:sexe,:photo,:id_promotion)";
    $requete = $connexion->prepare($requeteSQL);
    $requete->bindValue(":prenom", $prenom);
    $requete->bindValue(":nom", $nom);
    $requete->bindValue(":email", $email);
    $requete->bindValue(":adresse", $adresse);
    $requete->bindValue(":date", $date);
    $requete->bindValue(":telephone", $telephone);
    $requete->bindValue(":sexe", $sexe);
    $requete->bindValue(":photo", $photo);
    $requete->bindValue(":id_promotion", $id_promotion);
    return $requete->execute();
}




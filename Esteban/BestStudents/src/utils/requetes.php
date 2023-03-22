<?php
include "connexionDB.php";

function getAllStudents():array|bool{
    $connexion = createConnection();
    $requeteSQL = "SELECT * FROM etudiants";
    $requete = $connexion->prepare($requeteSQL);
    $requete->execute();
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}

function getStudentById($id){
    $connexion = createConnection();
    $requeteSQL = "SELECT * FROM etudiants WHERE id = :id";
    $requete = $connexion->prepare($requeteSQL);
    $requete->bindValue("id", $id);
    $requete->execute();
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}

function addStudent(string $prenom, string $nom, string $date_naissance, string $email, string $tel, string $adresse, string $ville, string $image, int $promo):bool{
    $connexion = createConnection();
    $requeteSQL = "INSERT INTO etudiants(prenom, nom, date_naissance, email, tel, adresse, ville, img, promo_etudiant)
 VALUES(:prenom, :nom, :date_naissance, :email, :tel, :adresse, :ville, :image, :promo)";
    $requete = $connexion->prepare($requeteSQL);
    $requete->bindValue("prenom", $prenom);
    $requete->bindValue("nom", $nom);
    $requete->bindValue("date_naissance", $date_naissance);
    $requete->bindValue("email", $email);
    $requete->bindValue("tel", $tel);
    $requete->bindValue("adresse", $adresse);
    $requete->bindValue("ville", $ville);
    $requete->bindValue("image", $image);
    $requete->bindValue("promo", $promo);
    return $requete -> execute();
}


function getAllPromo():array{
    $connexion = createConnection();
    $requete = $connexion-> prepare("SELECT * FROM promotions");
    $requete->execute();
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}

function getPromoNameById($id){
    $connexion = createConnection();
    $requete = $connexion->prepare("SELECT nom_promo FROM promotions WHERE id_promo = :id");
    $requete->bindValue("id", $id);
    $requete -> execute();
    return $requete->fetch(PDO::FETCH_ASSOC);
}

function getStudentsInPromo($id_promo){
    $connexion = createConnection();
    $requete = $connexion->prepare("SELECT * FROM etudiants WHERE promo_etudiant = :id_promo");
    $requete->bindValue("id_promo", $id_promo);
    $requete ->execute();
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}

function getAllHoraires(){
    $connexion = createConnection();
    $requete = $connexion-> prepare("SELECT * FROM horaires");
    $requete->execute();
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}

function createContact($nom, $prenom, $mail, $objet, $message){
    $connexion = createConnection();
    $requete = $connexion->prepare("INSERT INTO contact(nomContact, prenomContact, mailContact, objetContact, messageContact)
VALUES(:nom, :prenom, :mail, :objet, :message)");
    $requete->bindValue('nom', $nom);
    $requete->bindValue('prenom', $prenom);
    $requete->bindValue('mail', $mail);
    $requete->bindValue('objet', $objet);
    $requete->bindValue('message', $message);
    $requete->execute();
}

function getAllContact(){
    $connexion = createConnection();
    $requete = $connexion-> prepare("SELECT * FROM contact");
    $requete->execute();
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}

function getContactById($id){
    $connexion = createConnection();
    $requeteSQL = "SELECT * FROM contact WHERE idContact = :id";
    $requete = $connexion->prepare($requeteSQL);
    $requete->bindValue("id", $id);
    $requete->execute();
    return $requete->fetch(PDO::FETCH_ASSOC);
}

function getContactNonTraites(){
    $connexion = createConnection();
    $requete = $connexion-> prepare("SELECT * FROM contact WHERE traitementContact = 0");
    $requete->execute();
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}

function getContactTraites(){
    $connexion = createConnection();
    $requete = $connexion->prepare("SELECT * FROM contact WHERE traitementContact = 1");
    $requete->execute();
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}


function traiterContact($id){
    $connexion = createConnection();
    $requete = $connexion->prepare("UPDATE contact SET traitementContact = 1 WHERE idContact = :id");
    $requete ->bindValue('id', $id);
    $requete->execute();
}






function addUser($nom, $prenom, $login, $mdp, $acces){
    $connexion = createConnection();
    $requete = $connexion->prepare("INSERT INTO utilisateurs(nomUser, prenomUser, loginUser, mdpUser, accesAdmin)
VALUES (:nom, :prenom,:login, :mdp, :acces)");
    $requete->bindValue('nom', $nom);
    $requete->bindValue('prenom', $prenom);
    $requete->bindValue('login', $login);
    $requete->bindValue('mdp', password_hash($mdp, PASSWORD_DEFAULT));
    $requete->bindValue('acces', $acces);
    $requete->execute();
}

function verifUser($login, $mdp){
    $connexion = createConnection();
    $requete = $connexion->prepare("SELECT mdpUser FROM utilisateurs WHERE loginUser = :login");
    $requete->bindValue('login', $login);
    $requete->execute();
    $requete = $requete->fetch(PDO::FETCH_ASSOC);
    if (!empty($requete)){
        $mdpSauv = $requete['mdpUser'];
        if(password_verify($mdp, $mdpSauv)){
            return true;
        }else{
            return "Le mot de passe n'est pas valide.";
        }
    }else{
        return "Le login n'est pas reconnu.";
    }
}


<?php
require_once "connexionDB.php";
function getAllDemande(): array
{
    return requeteSQL("select * from contact");
}

function getContactById($id): array
{
    $requete = getConnexion()->prepare("Select * from contact where id_contact = :id");
    $requete->bindValue(":id", $id);
    $requete->execute();
    return $requete->fetchAll(2);
}
function addContact(string $nom, string $prenom, string $email, string $objet, string $message): bool
{
    $connexion = getConnexion();
    $requeteSQL = "INSERT INTO `contact` (`id_contact`, `nom_contact`, `prenom_contact`, `email_contact`, `objet_contact`, `message_contact`, `date_envoi_contact`, `etat_contact`) 
VALUES (NULL, :nom,:prenom,:email,:objet,:message,current_timestamp(),0);";
    $requete = $connexion->prepare($requeteSQL);
    $requete->bindValue(":nom", $nom);
    $requete->bindValue(":prenom", $prenom);
    $requete->bindValue(":email", $email);
    $requete->bindValue(":objet", $objet);
    $requete->bindValue(":message", $message);
    return $requete->execute();
}
function getContactForUser($id){
    $requete = getConnexion()->prepare("Select * from db_etudiants.user inner join db_etudiants.contact on user.id_user = contact.id_user where contact.id_user =user.id_user or user.email_user = contact.email_contact");
    $requete->bindValue(":id", $id);
    $requete->execute();
    return $requete->fetchAll(2);
}
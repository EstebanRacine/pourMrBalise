<?php
require_once "connexionDB.php";
function addUser(string $nom, string $prenom, string $email, string $username, string $mdp, $role)
{
    $connexion = getConnexion();
    $requeteSQL = "INSERT INTO `db_etudiants`.user 
VALUES (NULL, :nom,:prenom,:email,:username,:mdp,:role);";
    $requete = $connexion->prepare($requeteSQL);
    $requete->bindValue(":nom", $nom);
    $requete->bindValue(":prenom", $prenom);
    $requete->bindValue(":email", $email);
    $requete->bindValue(":username", $username);
    $requete->bindValue(":mdp", $mdp);
    $requete->bindValue(":role", $role);
    return $requete->execute();
}

function getUserByUsername($username)
{
    $requete = getConnexion()->prepare("select * from db_etudiants.user where username_user = :username");
    $requete->bindValue(":username", $username);
    $requete->execute();
    return $requete->fetchAll(2);
}
function getUserByIdUser($id_user)
{
    $requete = getConnexion()->prepare("select * from db_etudiants.user where id_user = :id_user");
    $requete->bindValue(":id_user", $id_user);
    $requete->execute();
    return $requete->fetchAll(2);
}

function checkConnexionUser($username, $mdp)
{
    $requete = getConnexion()->prepare("Select * from db_etudiants.user where username_user = :username");
    $requete->bindValue(":username", $username);
    $requete->execute();
    $user = $requete->fetchAll(2);
    if (!empty($user)){
        if (password_verify($mdp,$user[0]["mdp_user"])){
            return true;
        }
    }
    return false;
}

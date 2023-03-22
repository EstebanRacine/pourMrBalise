<?php
//lister l'ensemble des etudiants
//SQL : select * form etudiant
const DB_HOST = "localhost:3306";
const DB_BDD = "db_etudiants";
const DB_UTILISATEUR = "root";
const DB_MDP = "";
//créer la relation avec la BDD
function  getConnexion() : PDO{
    $DSN = "mysql:host=".DB_HOST.";dbname=".DB_BDD.";charset=utf8";
    try {
        $connexion = new PDO($DSN, DB_UTILISATEUR, DB_MDP);
        $connexion -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        return $connexion;
    } catch (PDOException $erreur) {
        die("Erreur : ".$erreur->getMessage());
    }
}
getConnexion();
function requeteSQL($requetesql)
{
    $requete = getConnexion()->prepare($requetesql);
    $requete->execute();
    return $requete->fetchAll(2);//PDO::FETCH_ASSOC
}

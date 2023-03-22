<?php

const DB_HOST = "localhost:3306";
const DB_NAME = "db_etudiants";
const DB_USER = "root";
const DB_PASSWORD = "";


function createConnection():PDO{
    $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8;";
    try {
        $connexion = new PDO($dsn, DB_USER, DB_PASSWORD);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connexion;
    } catch (PDOException $erreur){
        die("Erreur : ".$erreur->getMessage());
    }
}


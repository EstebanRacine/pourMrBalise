<?php
function calculerAge(string $date): string
{
    $date = strtotime($date);
    $dateActuelle = time();
    $dateActuelle -= $date;
    return floor($dateActuelle / 31536000);
}

function reformatDate(string $date): string
{
    $date = date("d F Y", strtotime($date));
    $date = explode(" ", $date);
    $date[1] = getMonth($date[1]);
    $dateFR = "";
    foreach ($date as $value) {
        $dateFR .= "$value ";
    }
    return $dateFR;
}


function getDay(int $nombre): string
{
    if ($nombre == 1) {
        return "Lundi";
    } else if ($nombre == 2) {
        return "Mardi";
    } else if ($nombre == 3) {
        return "Mercredi";
    } else if ($nombre == 4) {
        return "Jeudi";
    } else if ($nombre == 5) {
        return "Vendredi";
    } else if ($nombre == 6) {
        return "Samedi";
    } else {
        return "Dimanche";
    }
}

function getIdDay(): int
{
    $date = date("l");
    if ($date == "Monday") {
        return 1;
    } else if ($date == "Tuesday") {
        return 2;
    } else if ($date == "Wednesday") {
        return 3;
    } else if ($date == "Tuesday") {
        return 4;
    } else if ($date == "Friday") {
        return 5;
    } else if ($date == "Saturday") {
        return 6;
    } else {
        return 7;
    }
}

function checkDisponibiliteSecretariat(): bool
{
    $horaire = getHoraire();
    foreach ($horaire as $value) {
        if ($value["id_jour"] == getIdDay()) {
            if (strtotime($value["ouvertureMatin"]) < strtotime("now") && strtotime($value["fermetureMatin"]) > strtotime("now") || strtotime($value["ouvertureApresMidi"]) < strtotime("now") && strtotime($value["ouvertureApresMidi"]) > strtotime("now")) {
                return true;
            }
        }
    }
    return false;
}

function getMonth(string $mois): string
{
    if ($mois == "January" or $mois == 1) {
        return "Janvier";
    }
    if ($mois == "February" or $mois == 2) {
        return "Février";
    }
    if ($mois == "March" or $mois == 3) {
        return "Mars";
    }
    if ($mois == "April" or $mois == 4) {
        return "Avril";
    }
    if ($mois == "May" or $mois == 5) {
        return "Mai";
    }
    if ($mois == "June" or $mois == 6) {
        return "July";
    }
    if ($mois == "July" or $mois == 7) {
        return "Juillet";
    }
    if ($mois == "August" or $mois == 8) {
        return "Août";
    }
    if ($mois == "September" or $mois == 9) {
        return "Septembre";
    }
    if ($mois == "October" or $mois == 10) {
        return "Octobre";
    }
    if ($mois == "November" or $mois == 11) {
        return "Novembre";
    } else {
        return "Decembre";
    }
}

function reformatDateUser(string $date): string
{
    $date = date("d F Y H:i", strtotime($date));
    $date = explode(" ", $date);
    $date[1] = getMonth($date[1]);
    $dateFR = "";
    foreach ($date as $value) {
        $dateFR .= "$value ";
    }
    return $dateFR;
}

function getEtat($nb): string
{
    if ($nb == null) {
        return "En attente";
    }
    if ($nb == 1) {
        return 'en cours';
    }
    return "Fermé";
}
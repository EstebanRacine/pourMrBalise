<?php

include_once "requetes.php";

function writeBirthLetter(string $date_n):string{
    $annee = substr($date_n, 0, 4);
    $month = substr($date_n, 5, 2);
    if($month == "01"){
        $month = "Janvier";
    }elseif($month == "02"){
        $month = "Février";
    }elseif ($month == "03"){
        $month = "Mars";
    }elseif ($month == "04"){
        $month = "Avril";
    }elseif ($month == "05"){
        $month = "Mai";
    }elseif ($month == "06"){
        $month = "Juin";
    }elseif ($month == "07"){
        $month = "Juillet";
    }elseif ($month == "08"){
        $month = "Aout";
    }elseif ($month == "09"){
        $month = "Septembre";
    }elseif ($month == "10"){
        $month = "Octobre";
    }elseif ($month == "11"){
        $month = "Novembre";
    }else{
        $month = "Décembre";
    }
    $day = substr($date_n, -2);
    return $day." ".$month." ".$annee;
}

function writeBirthNumber(string $date_n):string{
    $annee = substr($date_n, 0, 4);
    $month = substr($date_n, 5, 2);
    $day = substr($date_n, -2);
    return $day."/".$month."/".$annee;
}

function getAge(string $date_n):int{
    $date_n = date_create($date_n);
    $now = date_create(date('Y-m-d'));
    $differenceDate = date_diff($date_n, $now);
    return $differenceDate->format("%y");
}

function ActuellementHoraires():bool{
    $time = time();
    $jour = date('N', $time);
    $heure = date("H", $time);
    $minute = date("i", $time);
    $heureTotal = $heure.':'.$minute;
    $heureTotal = strtotime($heureTotal);
    $horaires = getAllHoraires();
    foreach ($horaires as $day){
        if($day['id_jour']==$jour){
            if(!isset($day['ouvertureMatin']) and !isset($day['ouvertureApMidi'])){
                return False;
            }
            if (isset($day['ouvertureMatin'])){
                $heureOuv = strtotime(str_replace('h', ':', $day['ouvertureMatin']));
                $heureFerm = strtotime(str_replace('h', ':', $day['fermetureMatin']));
                if ($heureTotal < $heureFerm and $heureTotal>=$heureOuv){
                    return True;
                }
            }

            if (isset($day['ouvertureApMidi'])){
                $heureOuv = strtotime(str_replace('h', ':', $day['ouvertureApMidi']));
                $heureFerm = strtotime(str_replace('h', ':', $day['fermetureApMidi']));
                if ($heureTotal < $heureFerm and $heureTotal>=$heureOuv){
                    return True;
                }
            }
        }
    }
    return False;
}

function getNumberJour(){
    $time = time();
    $jour = date('N', $time);
    return $jour;
}
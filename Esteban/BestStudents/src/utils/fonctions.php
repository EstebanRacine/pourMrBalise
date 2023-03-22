<?php

function mailConfirmation($nom, $prenom, $mail){
    $headers = [
        "from"=>"noreply@beststudent.fr",
        "content-type"=> "text/plain; charset=utf-8"
    ];

    mail($mail, "Confirmation de contact", "Bonjour $prenom $nom , \n Votre message a bien été prit en compte et sera traité le plus rapidement possible.", $headers);
}


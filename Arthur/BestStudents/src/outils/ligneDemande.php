<?php
function createNewLine($id)
{
    $user = getContactById($id)[0];
    echo "<div class='lines'>
                <p>" . $user["id_contact"] . "</p>
                <p>" . strtoupper($user["nom_contact"]) . "</p>
                <p>" . ucfirst($user["prenom_contact"]) . "</p>
                <p>" . $user["email_contact"] . "</p>
                <p>" . $user["objet_contact"] . "</p>
                <p>" . reformatDateUser($user["date_envoi_contact"]) . "</p>
                <p>" . getEtat($user["etat_contact"]) . "</p>
                <form action=\"../support.php\" class='enSavoirPlus' method='post'><input type='hidden' name='id' id='id' value='$id'><input type='submit' value='En savoir plus'></form>
                </div>
        ";
}
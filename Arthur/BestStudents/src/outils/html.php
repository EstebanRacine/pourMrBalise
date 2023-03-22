<?php
function connexion($pseudo)
{
    echo "
    <form method='post'>
    <label for='pseudo'>Pseudo</label>
    <input placeholder='Pseudo' id='pseudo' type='text' name='pseudo' value=$pseudo>
    <label for='mdp'>Mot de passe</label>
    <input placeholder='Mot de passe' id='mdp' type='text' name='mdp'>
    <input type='submit' value='Se connecter'>
    <div class='separator'>
    <hr class=\"line\">
    <span>Ou</span>
    <hr class=\"line\">
    </div>
    <a href='../../formulaireConnexion.php'>Créer un compte</a>
</form>
    ";
}

function profil($id)
{
    $user = getUserByIdUser($id)[0];
    echo'<div class="profil">';
    if (date("H") > 19) {
        echo "<h4>Bonsoir,</h4>";
    } else {
        echo "<h4>Bonjour,</h4>";
    }
    echo "<p>" . ucfirst($user["nom_user"]) . " " . strtoupper($user["prenom_user"]) . "</p>
           <a href=''>Modifier le profil</a>
           <a href='../../demande.php'>Mes demandes</a>";
    if ($user["role_user"] == 1){
        echo "<a href='../../demande.php'>Toutes les demandes</a>";
    }
    echo "
           <form method='post'>
           <input type='submit' value='Se déconnecter' name='deco'>
</form></div>
           ";
}
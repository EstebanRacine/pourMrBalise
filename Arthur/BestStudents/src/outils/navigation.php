<?php
require_once "html.php";
require_once "src/modele/userDB.php";
$pseudo = null;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["pseudo"])) {
        $pseudo = $_POST["pseudo"];
        if (empty(trim($_POST["pseudo"])) || empty(trim($_POST["mdp"])) || !checkConnexionUser($_POST["pseudo"],$_POST["mdp"])){
            $erreur["connexion"] = "Echec de la connexion";
        }
         else {
             $_SESSION["id"] = getUserByUsername($pseudo)[0]["id_user"];
         }
    }
}
?>
<head>
    <link rel="stylesheet" href="../../styleBestStudents/styleConnexion.css">
</head>
<header><a href=""><img src="imageWeb/Logo.png" alt="logo" id="logo"></a>
    <svg id="burger" viewBox="0 0 100 100" width="80"
         onclick="this.classList.toggle('active'); document.querySelector('header > ul').classList.toggle('click');">
        <path class="line top"
              d="m 30,33 h 40 c 3.722839,0 7.5,3.126468 7.5,8.578427 0,5.451959 -2.727029,8.421573 -7.5,8.421573 h -20"/>
        <path class="line middle" d="m 30,50 h 40"/>
        <path class="line bottom"
              d="m 70,67 h -40 c 0,0 -7.5,-0.802118 -7.5,-8.365747 0,-7.563629 7.5,-8.634253 7.5,-8.634253 h 20"/>
    </svg>
    <ul>
        <li><a href="index.php">Accueil</a></li>
        <li><a href="formulaire.php">Ajouter un étudiant</a></li>
        <li><a href="contact.php">Contactez-nous</a></li>
        <li id="user">
            <svg class="svg-icon" viewBox="0 0 20 20"
                 onclick='this.parentNode.querySelector(".parametres").classList.toggle("show")' style="width: 40px">
                <path d="M12.075,10.812c1.358-0.853,2.242-2.507,2.242-4.037c0-2.181-1.795-4.618-4.198-4.618S5.921,4.594,5.921,6.775c0,1.53,0.884,3.185,2.242,4.037c-3.222,0.865-5.6,3.807-5.6,7.298c0,0.23,0.189,0.42,0.42,0.42h14.273c0.23,0,0.42-0.189,0.42-0.42C17.676,14.619,15.297,11.677,12.075,10.812 M6.761,6.775c0-2.162,1.773-3.778,3.358-3.778s3.359,1.616,3.359,3.778c0,2.162-1.774,3.778-3.359,3.778S6.761,8.937,6.761,6.775 M3.415,17.69c0.218-3.51,3.142-6.297,6.704-6.297c3.562,0,6.486,2.787,6.705,6.297H3.415z"></path>
            </svg>
            <p>connexion</p>
            <?php
            if(isset($erreur["connexion"])){
                echo "<div id='erreur'>".$erreur["connexion"]."</div>";
            }
            ?>
            <div class="parametres">
                <?php
                if (empty($_SESSION["id"])) {
                    connexion($pseudo);
                } else {
                    profil($_SESSION["id"]);
                }
                ?>
            </div>
        </li>
    </ul>
</header>
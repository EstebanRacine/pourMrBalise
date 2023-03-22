<?php
session_start();
if (!isset($_SESSION["id"])) {
    $_SESSION["id"] = [];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["deco"])) {
        $_SESSION["id"] = [];
    } else
        if (isset($_POST["pseudo"])) {
        } else {
        }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Connexion</title>
</head>
<body>

</body>
</html>

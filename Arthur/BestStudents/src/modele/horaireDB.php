<?php
require_once "connexionDB.php";
function getHoraire(): array
{
    return requeteSQL("select * from horaires");
}
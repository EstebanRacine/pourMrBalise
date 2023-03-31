<?php

require_once "Rectangle.php";

$rec1 = new Rectangle(2, 5, 'blanc');
echo $rec1->getCouleur().PHP_EOL;
echo $rec1->getInfosString();
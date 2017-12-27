<?php
include "functions.php";
spl_autoload_register('myAutoload');
includeAI("item");
includeAI("price");
$car = new Classes\Main\Car("Ford Focus",100000,"black");
$car->getProperties(); //Ford Focus black 100000

includeAI("actionduck");
$duck = new Classes\Main\Duck("Willy","black");

includeAI("actionpen");
$pen = new Classes\Main\Pen("Bic","blue");

includeAI("tvcontrols");
$tv = new Classes\Main\TV("Toshiba");

includeAI("itemaction");
$someItem = new Classes\Main\SomeItem("Potato",50,50);
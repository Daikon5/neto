<?php
include "functions.php";
spl_autoload_register('myAutoload');
$car = new Classes\Main\Car("Ford Focus",100000,"black");
$car->getProperties(); //Ford Focus black 100000

$duck = new Classes\Main\Duck("Willy","black");

$pen = new Classes\Main\Pen("Bic","blue");

$tv = new Classes\Main\TV("Toshiba");

$potato = new Classes\Main\SomeItem("Potato",50,50);

$cart = new Classes\Main\Cart();
$cart->getItem($potato);
$cart->cartContents(); // В корзине 1 товаров на 50 денег
$cart->getItem($car);
$cart->cartContents(); // В корзине 2 товаров на 100050 денег
$cart->delItem($potato);
$cart->cartContents(); // В корзине 1 товаров на 100000 денег

$order = new Classes\Main\Order($cart);
$order->getSum(); // Ваш заказ: 1. Ford Focus на стоимостью 100000 денег. Итого к оплате: 100000

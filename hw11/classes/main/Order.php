<?php
namespace Classes\Main;
class Order
{
    private $items;
    public function __construct($cart)
    {
        $this->items = $cart->items;
    }
    public function getSum() {
        $sum = 0;
        $count = 1;
        echo "Ваш заказ:".PHP_EOL;
        foreach ($this->items as $name => $price) {
            echo "$count. $name на стоимостью $price денег.".PHP_EOL;
            $sum += $price;
        }
        echo "Итого к оплате: $sum";
    }
}
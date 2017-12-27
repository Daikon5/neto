<?php
namespace Classes\Main;
class Cart
{
    public $items = [];
    public function getItem($item) {
        $this->items[$item->name] = $item->price;
    }
    public function delItem($item) {
        unset($this->items[$item->name]);
    }
    public function cartContents() {
        $sum = 0;
        $count = 0;
        foreach ($this->items as $name => $price) {
            $count++;
            $sum += $price;
        }
        echo "В корзине $count товаров на $sum денег".PHP_EOL;
    }
}
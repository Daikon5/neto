<?php
namespace Classes\Main;
class Cart
{
    protected $sum = 0;
    protected $names = [];
    public function getItem($item) {
        $this->sum += $item->$price;
        $this->names[] = [$item->$name => $item->$price];
    }
    public function delItem($item) {

    }
}
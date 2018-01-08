<?php
namespace Classes\Main;
use \Classes\Abs\Item;
use \Classes\Interfaces\ItemAction;
class SomeItem extends Item implements ItemAction
{
    public $price;
    private $count;

    public function __construct($n,$price,$count)
    {
        parent::__construct($n);
        $this->price = $price;
        $this->count = $count;
    }
    public function sellItem($number) {
        $this->count = $this->count - $number;
        echo "Продано $number единиц товара $this->name, на складе: $this->count.";
    }
}
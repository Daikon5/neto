<?php
namespace Classes\Main;
class SomeItem extends \Classes\Abs\Item implements \Classes\Interfaces\ItemAction
{
    private $price;
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
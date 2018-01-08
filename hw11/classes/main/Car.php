<?php
namespace Classes\Main;
use \Classes\Abs\Item;
use \Classes\Interfaces\Price;
class Car extends Item implements Price
{
    public $price;
    protected $color;
    protected $discount;

    public function __construct($n,$price,$color)
    {
        parent::__construct($n);
        $this->price = $price;
        $this->color = $color;
    }
    public function setPrice($price)
    {
        $this->price = $price;
    }
    public function getPrice()
    {
        echo $this->price."\n";
    }
    public function setDiscount($discount)
    {
        $this->discount = $discount;
        $this->price = ($this->price)*(1-($this->discount/100));
    }
    public function getProperties()
    {
        echo $this->name."\n";
        echo $this->color."\n";
        echo $this->price."\n";
        echo $this->discount."\n";
    }
}
<?php
namespace Classes\Main;
use \Classes\Abs\Item;
use \Classes\Interfaces\ActionPen;
class Pen extends Item implements ActionPen
{
    private $color;

    public function __construct($n,$color)
    {
        parent::__construct($n);
        $this->color = $color;
    }
    public function changeColor($color)
    {
        if (isset($color)) {
            $this->color = $color;
            echo "Вы сменили цвет пасты в ручке $this->name на: $this->color."."\n";
        }
    }
}
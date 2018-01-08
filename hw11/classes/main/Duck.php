<?php
namespace Classes\Main;
use \Classes\Abs\Item;
use \Classes\Interfaces\ActionDuck;
class Duck extends Item implements ActionDuck
{
    private $color;
    private $legsNumber = 2;
    private $isFried = 0;

    public function __construct($n,$color)
    {
        parent::__construct($n);
        $this->color = $color;
    }
    public function fryDuck() {
        $this->isFried = 1;
        echo "Прощай, ".$this->name.".";
    }
    public function getLeg() {
        if ($this->isFried == 1 && $this->legsNumber > 0) {
            $this->legsNumber -= 1;
            echo "Вы взяли ножку, приятного аппетита.";
        }
        elseif ($this->isFried == 1 && $this->legsNumber == 0) {
            echo "У уточки больше нет ножек, возьмите крылышко.";
        }
        else {
            echo "Ужас, вы садист!";
        }
    }
}
Наследование - передача классам-потомкам свойств и методов для их получения/обработки,
а суть полмирофизма в том что дочерний класс может переопределять и свойства и методы,
заданные родителем, и обзаводиться своими собственными.
Грубо говоря - дочерние классы имеют возможность сами решать как поступить с родительским "наследством".

Абстрактный класс может содержать свойства, и абстрактные/неабстрактные методы, не может быть использован для создания
объектов, только для создания классов-потомков и при этом требует реализации всех своих абстрактных методов в них.
Интерфейс же - так сказать сказать "заготовка" из абстрактных методов для имплементации в классы, после имплементации
в неабстрактный класс так же требует реализации всех своих методов в потомке.
Класс может иметь только один суперкласс, интерфейсов же можно имплементировать много.


<?php
class Item
{
    protected $name;

    protected function __construct($name)
    {
        $this->name = $name;
    }
}

interface Price {
    public function getPrice();
    public function setPrice($price);
}

class Car extends Item implements Price
{
    protected $price;
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

$ford = new Car("Ford Focus",1000000,"Black");
$ford->setDiscount(14);
$ford->getPrice(); // 860000

interface TvControls
{
    public function tvOn($channel);
    public function tvOff();
    public function channelSwitch($channel);
}

class TV extends Item implements TvControls
{
    private $work = 0;
    private $channel = 0;

    public function __construct($n)
    {
        parent::__construct($n);
    }
    public function tvOn($channel) {
        $this->work = 1;
        $this->channel = $channel;
    }
    public function tvOff() {
        $this->work = 0;
    }
    public function channelSwitch($channel) {
        if ($this->work = 1) {
            $this->channel = $channel;
        }
    }
    public function tvStatus() {
        echo $this->name."\n";
        if ($this->work = 1) {
            echo "TV works, channel is $this->channel."."\n";
        }
        else {
            echo "TV is OFF.";
        }
    }
}

$sony = new TV("Sony");
$lg = new TV ("LG");

$lg->tvOn(5);
$lg->channelSwitch(1);
$lg->tvStatus(); // LG TV works, channel is 1.

interface ActionPen {
    public function changeColor($color);
}

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

$bic = new Pen("Bic","blue");
$erichKrause = new Pen ("Erich Krause", "black");
$bic->changeColor("green");

interface ActionDuck {
    public function fryDuck();
    public function getLeg();
}

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

$billy = new Duck("Billy","White");
$willy = new Duck("Willy","Black");
$dilly = new Duck("Dilly","Grey");

$willy->fryDuck(); // Прощай, Willy.
$willy->getLeg(); // Вы взяли ножку, приятного аппетита
$dilly->getLeg(); // Ужас, вы садист

interface ItemAction {
    public function sellItem($number);
}

class SomeItem extends Item implements ItemAction
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

$vobla = new SomeItem("Вобла",50,300);
$beer = new SomeItem('Пиво',100,50);
$beer->sellItem(6); // Продано 6 единиц товара Пиво, на складе: 44.

Инкапсуляция - возможность отделить данные (параметры) одного экземпляра класса (обеъекта) от всех прочих
и работать с каждым объектом отдельно, ограничивая на свое усмотрение доступ разных компонентов программы друг к другу,
возможность связать данные и методы для обработки этих данных в "капсуле" класса.

Плюсы объектов:
- параметры связаны с методами их обработки
- ограничение доступа если нужно
- возможность масштабирования
- краткий код
- легкость "обслуживания"

Минусы объектов:
- относительная сложность для понимания
- важно помнить откуда и на какой объет ты ссылаешься/ссылался

<?php
class Car
{
    private $name;
    private $model;
    private $color;
    private $price;
    private $discount;

    public function __construct($name,$model,$color,$price)
    {
        $this->name = $name;
        $this->model = $model;
        $this->color = $color;
        $this->price = $price;
    }
    public function setDiscount($discount)
    {
        $this->discount = $discount;
        $this->price = ($this->price)*(1-($this->discount/100));
    }
    public function getProperties()
    {
        echo $this->name."\n";
        echo $this->model."\n";
        echo $this->color."\n";
        echo $this->price."\n";
        echo $this->discount."\n";
    }
}

$ford = new Car("Ford","Focus","Black","1000000");
$bmw = new Car("BMW","X5","White","3000000");

$ford->setDiscount(15);
$ford->getProperties(); // Ford Focus Black 850000 15

class TV
{
    private $mark;
    private $work = 0;
    private $channel = 0;

    public function __construct($mark)
    {
        $this->mark = $mark;
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
        echo $this->mark."\n";
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

class Pen
{
    private $name;
    private $color;

    public function __construct($name,$color)
    {
        $this->name = $name;
        $this->color = $color;
    }
}

$bic = new Pen("Bic","blue");
$erichKrause = new Pen ("Erich Krause", "black");

class Duck
{
    private $name;
    private $color;
    private $legsNumber = 2;
    private $isFried = 0;

    public function __construct($name,$color)
    {
        $this->name = $name;
        $this->color = $name;
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

class SomeItem
{
    private $name;
    private $price;
    private $count;

    public function __construct($name,$price,$count)
    {
        $this->name = $name;
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

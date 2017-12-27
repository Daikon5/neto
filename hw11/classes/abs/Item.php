<?php
namespace Classes\Abs;
abstract class Item
{
    public $name;

    protected function __construct($name)
    {
        $this->name = $name;
    }
}
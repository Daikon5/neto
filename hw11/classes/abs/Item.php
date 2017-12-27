<?php
namespace Classes\Abs;
abstract class Item
{
    protected $name;

    protected function __construct($name)
    {
        $this->name = $name;
    }
}
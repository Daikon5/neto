<?php
namespace Classes\Main;
use \Classes\Abs\Item;
use \Classes\Interfaces\TvControls;
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
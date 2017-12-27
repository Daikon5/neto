<?php
namespace Classes\Interfaces;
interface TvControls
{
    public function tvOn($channel);
    public function tvOff();
    public function channelSwitch($channel);
}
<?php


namespace rain1208\onigame\map;


use pocketmine\level\Level;

class Map
{
    private $original;

    public function __construct(Level $original)
    {
        $this->original = $original;
    }
}
<?php

namespace rain1208\tennis;

use pocketmine\entity\Living;

class SlimeBall extends Living
{
    public const NETWORK_ID = self::SLIME;

    public $height = 0.2;
    public $width = 0.2;

    public function getName(): string
    {
        return "tennisBall";
    }

    public function getDrops(): array
    {
        return [];
    }
}
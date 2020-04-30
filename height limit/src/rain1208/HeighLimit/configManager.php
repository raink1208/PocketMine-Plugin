<?php


namespace rain1208\HeighLimit;


use pocketmine\utils\Config;

class configManager
{
    /**
     * @var Config
     */
    private static $datafile;

    public static function loadConfig(Config $config) {
        self::$datafile = $config;
    }

    public static function set(string $world,int $heigh) {
        self::$datafile->set($world,$heigh);
        self::$datafile->save();
    }
}
<?php


namespace rain1208\policeSystem;


use pocketmine\utils\Config;

class ConfigManager
{
    /**
     * @var Config
     */
    private static $dataFile;

    public static function loadConfig(Config $config) {
        self::$dataFile = $config;
    }

    public static function exists($name):bool {
        return self::$dataFile->exists($name);
    }

    public static function set($name) {
        self::$dataFile->set($name);
        self::$dataFile->save();
    }

    public static function del($name) {
        self::$dataFile->remove($name);
        self::$dataFile->save();
    }
}
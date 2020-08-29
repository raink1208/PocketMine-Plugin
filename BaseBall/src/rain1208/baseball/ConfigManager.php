<?php


namespace rain1208\baseball;


use pocketmine\utils\Config;

class ConfigManager
{
    /** @var Config */
    private static $config;
    public static function loadConfig(Config $config) {
        self::$config = $config;
    }

    public static function set(float $m) {
        self::$config->set("multiply",$m);
        self::$config->save();
    }
    /** @return float */
    public static function get() {
        return self::$config->get("multiply");
    }
}
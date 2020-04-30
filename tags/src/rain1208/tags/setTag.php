<?php


namespace rain1208\tags;


use pocketmine\Player;
use pocketmine\utils\Config;

class setTag
{
    /**
     * @var Config
     */
    private static $tags;
    
    public static function loadTags(Config $tags) {
        self::$tags = $tags;
    }

    public function __construct(Player $player,int $level = 0)
    {
        $tag = (self::$tags->exists($player->getName()))? self::$tags->get($player->getName()):"未設定";
        $player->setDisplayName("Lv: {$level}[{$tag}]{$player->getName()}");
        $player->setNameTag("Lv: {$level}[{$tag}]{$player->getName()}");
    }
}
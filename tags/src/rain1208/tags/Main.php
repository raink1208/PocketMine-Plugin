<?php


namespace rain1208\tags;


use Deceitya\MiningLevel\Event\MiningLevelUpEvent;
use Deceitya\MiningLevel\MiningLevelAPI;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener
{
    /**
     * @var Config
     */
    private $Tag;
    /**
     * @var Config
     */
    private $shop;

    public function onEnable()
    {
        if (!file_exists($this->getDataFolder())) {
            mkdir($this->getDataFolder(), 0744,true);
        }
        $this->shop = new Config($this->getDataFolder()."shop.yml",Config::YAML);
        $this->Tag = new Config($this->getDataFolder()."tags.yml",Config::YAML);
        tagShop::loadConfig($this->shop,$this->Tag);
        setTag::loadTags($this->Tag);
        $this->getServer()->getPluginManager()->registerEvents($this,$this);
        $this->getServer()->getPluginManager()->registerEvents(new tagShop(),$this);
    }

    public function onJoin(PlayerJoinEvent $event) {
        $player = $event->getPlayer();
        $level = MiningLevelAPI::getInstance()->getLevel($player);
        new setTag($player,$level);
    }

    public function LevelUpEvent(MiningLevelUpEvent $event) {
        $player = $event->getPlayer();
        $level = $event->getTo();
        new setTag($player,$level);
    }
}
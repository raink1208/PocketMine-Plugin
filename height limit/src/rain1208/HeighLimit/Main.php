<?php


namespace rain1208\HeighLimit;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener
{
    /**
     * @var Config
     */
    private $Limit;

    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents($this,$this);
        if (!file_exists($this->getDataFolder())) {
            mkdir($this->getDataFolder(),0744,true);
        }
        $this->Limit = new Config($this->getDataFolder()."HeighLimit.yml",Config::YAML,array(
            "world" => 255 #example
        ));
        configManager::loadConfig($this->Limit);
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        if ($label == "wdlim") {
            if ($sender instanceof Player) {
                $sender->sendForm(new UI($sender));
            } else {
                $sender->sendMessage("ワールド内から使用してください");
            }
        }
        return true;
    }

    public function onPlace(BlockPlaceEvent $event) {
        if ($event->getPlayer()->isOp()) return;
        $worldName = $event->getBlock()->getLevel()->getName();
        $blockY = $event->getBlock()->getFloorY();
        if ($this->Limit->exists($worldName)) {
            if ($this->Limit->get($worldName) < $blockY) {
                $event->setCancelled();
                $event->getPlayer()->sendMessage("[§aHeighLimit§r]このワールドの高さ制限は§b".$this->Limit->get($worldName)."§rまでです");
            }
        }
    }

    public function onBreak(BlockBreakEvent $event) {
        if ($event->getPlayer()->isOp()) return;
        $worldName = $event->getBlock()->getLevel()->getName();
        $blockY = $event->getBlock()->getFloorY();
        if ($this->Limit->exists($worldName)) {
            if ($this->Limit->get($worldName) < $blockY) {
                $event->setCancelled();
                $event->getPlayer()->sendMessage("[§aHeighLimit§r]このワールドの高さ制限は§b".$this->Limit->get($worldName)."§rまでです");
            }
        }
    }
    public function onDisable()
    {
    }
}
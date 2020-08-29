<?php


namespace rain1208\baseball;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\object\ItemEntity;
use pocketmine\item\ItemIds;
use pocketmine\item\Stick;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase
{
    /** @var Config */
    private $config;
    public function onEnable()
    {
        $this->config = new Config($this->getDataFolder()."config.yml",Config::YAML);
        $this->config->set("multiply",2);
        ConfigManager::loadConfig($this->config);
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(),$this);
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        switch ($label) {
            case "bat":
                if ($sender instanceof Player) {
                    $item = new Stick(1);
                    $item->setCustomName("バット");
                    $sender->getInventory()->addItem($item);
                    $sender->sendMessage("バットを配布しました");
                }
                break;
            case "multiply":
                if (isset($args[0])) {
                    if (is_numeric($args[0])) {
                        ConfigManager::set((int)$args[0]);
                        $sender->sendMessage("multiplyを".$args[0]."に変更しました");
                    } else {
                        $sender->sendMessage("数値を入力してください");
                    }
                } else {
                    $sender->sendMessage("/multiply <数値>");
                }
                break;
            case "clearball":
                if ($sender instanceof Player) {
                    foreach ($sender->getLevel()->getEntities() as $entity) {
                        if ($entity instanceof ItemEntity) {
                            if ($entity->getItem()->getId() === ItemIds::SNOWBALL) $entity->kill();
                        }
                    }
                }
        }
        return true;
    }
}
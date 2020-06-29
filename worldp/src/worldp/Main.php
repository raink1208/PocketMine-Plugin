<?php

namespace worldp;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase
{
    private static $instance;

    /** @var ConfigManager */
    public $configManager;

    public function onEnable()
    {
        self::$instance = $this;
        $this->configManager = new ConfigManager();
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(),$this);
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        if (!$sender instanceof Player) {
            $sender->sendMessage("§cゲーム内で実行してください");
            return true;
        }
        if (!isset($args[0])) return false;
        switch ($command->getName()) {
            case "worldbreak":
                $config = $this->configManager->getConfig(ConfigManager::BREAK);
                $this->protection($sender,$config,$args[0]);
                break;
            case "worldput":
                $config = $this->configManager->getConfig(ConfigManager::PLACE);
                $this->protection($sender,$config,$args[0]);
                break;
            case "canbreak":
                if(!isset($args[0])) break;
                if (!strpos($args[0],":")) break;
                $config = $this->configManager->getConfig(ConfigManager::BREAK);
                $this->canProtection($sender,$config,$args[0]);
                break;
            case "canput":
                if (!isset($args[0])) break;
                if (!strpos($args[0],":")) break;
                $config = $this->configManager->getConfig(ConfigManager::PLACE);
                $this->canProtection($sender,$config,$args[0]);
        }
        return true;
    }

    private function canProtection(Player $player,Config $config,string $args):void {
        $world = $player->getLevel()->getName();
        if ($config->exists($world)) {
            if (is_array($config->get($world))) {
                $list = $config->get($world);
                $list = in_array($args,$list)? array_diff($list,[$args]): array_push($list,$args);
                $config->set($world,$list);
                $config->save();
                return;
            }
            $config->set($world,$args);
            $config->save();
            return;
        }
        $config->set($world,[$args]);
        $config->save();
    }

    private function protection(Player $player,Config $config,string $args):void {
        $world = $player->getLevel()->getName();
        if ($args == "on") {
            $player->sendMessage("ワールド保護を有効にしました");
            $config->set($world,true);
            $config->save();
        } else if ($args == "off") {
            $player->sendMessage("ワールド保護を解除しました");
            $config->remove($world);
            $config->save();
        }
    }

    public static function getInstance(): Main
    {
        return self::$instance;
    }
}
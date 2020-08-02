<?php


namespace rain1208\poker;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use rain1208\poker\form\MainForm;

class Main extends PluginBase
{
    public static $instance;

    /** @var Config */
    private $config;
    /** @var PokerGame[] */
    private $games;

    public function onEnable()
    {
        self::$instance = $this;
        $this->config = new Config($this->getDataFolder()."config.yml",Config::YAML);
        if (is_null($this->getServer()->getPluginManager()->getPlugin("EconomyAPI"))) {
            $this->getLogger()->error("EconomyAPIが見つかりませんでした");
            $this->getServer()->getPluginManager()->disablePlugin($this);
        }
    }

    public static function getInstance(): self
    {
        return self::$instance;
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        if (!$sender instanceof Player) return true;
        switch ($command->getName()) {
            case "poker":
                $sender->sendForm(new MainForm($sender));
        }
        return true;
    }

    public function createGame(string $name,int $minBet ,Player $player)
    {
        $this->games[$player->getName()] = new PokerGame($name,$minBet);
    }

    public function getAllGame():array
    {
        return $this->games;
    }

    public function getGameName(): ?array
    {
        if (count($this->games) >= 1) {
            $name = [];
            foreach ($this->games as $game) {
                $name[] = $game->getName();
            }
            return $name;
        }
        return null;
    }
}
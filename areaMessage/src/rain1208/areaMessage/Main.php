<?php


namespace rain1208\areaMessage;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use rain1208\areaMessage\Form\createForm;
use rain1208\areaMessage\Form\ListForm;
use rain1208\areaMessage\Form\removeForm;

class Main extends PluginBase implements Listener
{
    /** @var SQLiteDatabase */
    public static $db;

    private $pos1;
    private $pos2;

    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents($this,$this);
        self::$db = new SQLiteDatabase($this);
        $this->getScheduler()->scheduleRepeatingTask(new checkTask(),20);
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        if ($label === "areamsg") {
            if ($sender instanceof Player) {
                if ($sender->isOp()) {
                    if (isset($args[0])) {
                        switch ($args[0]) {
                            case "create":
                                if (!isset($this->pos1) && !isset($this->pos2)) {
                                    $sender->sendMessage("posがセットされていません");
                                    break;
                                }
                                $sender->sendForm(new createForm($this->pos1,$this->pos2));
                                break;
                            case "pos1":
                                $this->pos1 = $sender->getPosition();
                                $sender->sendMessage("pos1を設定しました");
                                break;
                            case "pos2":
                                $this->pos2 = $sender->getPosition();
                                $sender->sendMessage("pos2を設定しました");
                                break;
                            case "list":
                                $sender->sendForm(new ListForm());
                                break;
                            case "remove":
                                $sender->sendForm(new removeForm());
                        }
                    } else {
                        $sender->sendMessage("/areamsg < create | pos1 | pos2 | list | remove >");
                    }
                } else {
                    $sender->sendMessage("このコマンドはop専用です");
                }
            } else {
                $sender->sendMessage("サーバー内から使ってください");
            }
        }
        return true;
    }
}
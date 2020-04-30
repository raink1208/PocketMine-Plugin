<?php


namespace rain1208\HeighLimit;


use pocketmine\form\Form;
use pocketmine\Player;
use pocketmine\Server;

class UI implements Form
{
    /**
     * @var array
     */
    private static $worlds;
    private static $level;

    public function __construct(Player $player)
    {
        self::$worlds = [];
        self::$level = $player->getLevel()->getName();
        foreach (Server::getInstance()->getLevels() as $world) {
            self::$worlds[] = $world->getName();
        }
    }

    /**
     * @inheritDoc
     */
    public function handleResponse(Player $player, $data): void
    {
        if ($data == null) {
            return;
        }
        if (isset($data[2])) {
            $player->sendMessage("高さが入力されていません");
            return;
        }
        configManager::set(self::$worlds[$data[1]],$data[2]);
        $player->sendMessage("[§aHeighLimit§r]".self::$worlds[$data[1]]."の高さ制限を".$data[2]."に設定しました");
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            "type" => "custom_form",
            "title" => "HeighLimit",
            "content" => [
                [
                    "type" => "label",
                    "text" => "あなたの今いるワールドは§b".self::$level."§rです"
                ],
                [
                    "type" => "dropdown",
                    "text" => "高さを設定するワールド",
                    "options" => self::$worlds,
                    "default" => 0
                ],
                [
                    "type" => "input",
                    "text" => "高さの入力0~256"
                ]
            ]
        ];

    }
}
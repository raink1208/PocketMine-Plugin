<?php


namespace rain1208\onigame\map\form;


use pocketmine\form\Form;
use pocketmine\form\FormValidationException;
use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\Server;
use rain1208\onigame\Main;
use rain1208\onigame\map\Map;


class SetMapForm implements Form
{
    private $worlds;

    private $message = "";

    public function handleResponse(Player $player, $data): void
    {
        if ($data === null) {
            $this->message = "入力されていない欄があります";
            return;
        }
        if (!is_string($data[2])) {
            $this->message = "マップの名前が入力されていません";
            $player->sendForm($this);
            return;
        }
        Main::getInstance()->getMapManager()->setMap($data[2],Server::getInstance()->getLevelByName($this->worlds[$data[1]]));
        $player->sendMessage("鬼ごっこのマップを登録しました");
    }

    public function jsonSerialize()
    {
        return [
            "type" => "custom_form",
            "title" => "鬼ごっこマップの追加",
            "content" => [
                [
                    "type" => "label",
                    "text" => $this->message
                ],
                [
                    "type" => "dropdown",
                    "text" => "ワールドの選択",
                    "options" => $this->getAllWorld(),
                    "default" => 0
                ],
                [
                    "type" => "input",
                    "text" => "マップの名前"
                ]
            ]
        ];
    }
    private function getAllWorld()
    {
        $worlds = [];
        foreach (Server::getInstance()->getLevels() as $world) {
            array_push($worlds,$world->getName());
        }
        return $this->worlds = $worlds;
    }
}
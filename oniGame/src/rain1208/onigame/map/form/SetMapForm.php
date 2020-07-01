<?php


namespace rain1208\onigame\map\form;


use pocketmine\form\Form;
use pocketmine\form\FormValidationException;
use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\Server;
use rain1208\onigame\Main;


class SetMapForm implements Form
{
    public function handleResponse(Player $player, $data): void
    {
        $mapManager = Main::getInstance()->getMapManager();
        if (empty($data[1])) {
            $player->sendMessage("マップ名が入力されていません");
            return;
        }
        if ($mapManager->mapExists($data[1])) {
            $player->sendMessage("既にその名前のマップはあります");
            return;
        }
        $mapManager->setMap($data[1],$this->getAllWorlds()[$data[0]]);
        $player->sendMessage("鬼ごっこのマップを登録しました");
    }

    public function jsonSerialize()
    {
        return [
            "type" => "custom_form",
            "title" => "鬼ごっこマップの追加",
            "content" => [
                [
                    "type" => "dropdown",
                    "text" => "ワールドの選択",
                    "options" => array_map(function (Level $world) { return $world->getName(); },$this->getAllWorlds()),
                    "default" => 0
                ],
                [
                    "type" => "input",
                    "text" => "マップの名前"
                ]
            ]
        ];
    }
    private function getAllWorlds(): array
    {
        return Server::getInstance()->getLevels();
    }
}
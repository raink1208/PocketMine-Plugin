<?php


namespace rain1208\areaMessage\Form;


use pocketmine\form\Form;
use pocketmine\form\FormValidationException;
use pocketmine\Player;
use rain1208\areaMessage\Main;

class removeForm implements Form
{
    private $names = [];
    public function handleResponse(Player $player, $data): void
    {
        if ($data === null) {
            return;
        }
        Main::$db->removeArea($this->names[$data]);
        $player->sendMessage("AreaMessageを削除しました name:".$this->names[$data]);
    }
    public function jsonSerialize()
    {
        return [
            "type" => "form",
            "title" => "AreaMessage_List",
            "content" => "削除するエリアを選択してください",
            "buttons" => $this->getButton()
        ];
    }
    public function getButton() {
        $name = Main::$db->getName();
        $res = [];
        foreach ($name as $item) {
            array_push($res,["text" => $item["name"]]);
            array_push($this->names,$item["name"]);
        }
        return $res;
    }
}
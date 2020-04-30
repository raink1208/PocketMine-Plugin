<?php


namespace rain1208\areaMessage\Form;


use pocketmine\form\Form;
use pocketmine\form\FormValidationException;
use pocketmine\Player;
use rain1208\areaMessage\Main;

class ListForm implements Form
{
    private $names = [];
    public function handleResponse(Player $player, $data): void
    {
        if ($data === null) {
            return;
        }
        $player->sendForm(new infoForm($this->names[$data]));
    }
    public function jsonSerialize()
    {
        return [
            "type" => "form",
            "title" => "AreaMessage_List",
            "content" => "操作を行う物を選んでください",
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
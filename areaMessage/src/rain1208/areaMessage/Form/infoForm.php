<?php


namespace rain1208\areaMessage\Form;


use pocketmine\form\Form;
use pocketmine\form\FormValidationException;
use pocketmine\Player;
use rain1208\areaMessage\Main;

class infoForm implements Form
{
    private $name;
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function handleResponse(Player $player, $data): void
    {
        if ($data === null) {
            return;
        }
        Main::$db->changeMessage($this->name,$data[5]);
    }

    public function jsonSerialize()
    {
        return [
            "type" => "custom_form",
            "title" => "AreaMessageInfo",
            "content" => $this->getInfo()
        ];
    }

    public function getInfo():array {
        $result = Main::$db->getDataByName($this->name);
        return [
            [
                "type" => "label",
                "text" => $result["name"]."の編集画面です"
            ],
            [
                "type" => "label",
                "text" => "world名 : ".$result["world"]
            ],
            [
                "type" => "label",
                "text" => "X座標 : ".$result["posX"]
            ],
            [
                "type" => "label",
                "text" => "Y座標 : ".$result["posY"]
            ],
            [
                "type" => "label",
                "text" => "Z座標 : ".$result["posZ"]
            ],
            [
                "type" => "input",
                "text" => "表示するメッセージ",
                "default" => $result["message"]
            ]
        ];
    }
}
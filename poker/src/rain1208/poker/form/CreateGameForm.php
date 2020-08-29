<?php


namespace rain1208\poker\form;


use pocketmine\form\Form;
use pocketmine\form\FormValidationException;
use pocketmine\Player;
use rain1208\poker\Main;

class CreateGameForm implements Form
{
    public function handleResponse(Player $player, $data): void
    {
        if ($data === null) return;
        if ($data[0] !== null && $data[0] !== "") {
            Main::getInstance()->createGame($data[0],$data[1],$player);
        }
    }

    public function jsonSerialize()
    {
        return [
            "type" => "custom_form",
            "title" => "Game Create Form",
            "content" => [
                [
                    "type" => "input",
                    "text" => "ゲーム名",
                ],
                [
                    "type" => "step_slider",
                    "text" => "最低ベット額",
                    "steps" => ["1","10","100","1000","一万"],
                    "default" => 0
                ]
            ]
        ];
    }
}
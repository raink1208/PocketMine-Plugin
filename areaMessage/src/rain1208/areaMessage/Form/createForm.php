<?php


namespace rain1208\areaMessage\Form;


use pocketmine\form\Form;
use pocketmine\form\FormValidationException;
use pocketmine\level\Position;
use pocketmine\Player;
use rain1208\areaMessage\Main;

class createForm implements Form
{
    private $posX;
    private $posY;
    private $posZ;

    public function __construct(Position $pos1, Position $pos2)
    {
        $x = [$pos1->getFloorX(),$pos2->getFloorX()];
        $y = [$pos1->getFloorY(),$pos2->getFloorY()];
        $z = [$pos1->getFloorZ(),$pos2->getFloorZ()];
        sort($x);
        sort($y);
        sort($z);
        $y[0] -= 1;
        $this->posX = implode($x,",");
        $this->posY = implode($y,",");
        $this->posZ = implode($z,",");
    }

    public function handleResponse(Player $player, $data): void
    {
        if ($data == null) {
            return;
        }
        Main::$db->createAreaMessage($data[0],$player->getLevel()->getName(),$this->posX,$this->posY,$this->posZ,$data[1]);
        $player->sendMessage("AreaMessageを新しく作りましたname:".$data[0]);
    }

    public function jsonSerialize()
    {
        return [
            "type" => "custom_form",
            "title" => "AreaMessage",
            "content" => [
                [
                    "type" => "input",
                    "text" => "name(削除編集するときに使います既にあるnameは使えません)"
                ],
                [
                    "type" => "input",
                    "text" => "範囲内に参加したときに表示するメッセージ"
                ]
            ]
        ];
    }
}
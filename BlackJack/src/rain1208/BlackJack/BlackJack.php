<?php


namespace rain1208\BlackJack;


use pocketmine\Player;

class BlackJack
{
    private $players = [];

    public function join(Player $player) {
        if (in_array($player->getName(),$this->players)) {
            $player->sendMessage("既に参加しています");
        } else {
            array_push($this->players,$player->getName());
            $player->sendMessage("参加しました");
        }
    }

    public function leave(Player $player) {
        if (in_array($player->getName(),$this->players)) {
            unset($this->players[$player->getName()]);
            $player->sendMessage("退出しました");
        } else {
            $player->sendMessage("あなたは参加していません");
        }
    }
    
}
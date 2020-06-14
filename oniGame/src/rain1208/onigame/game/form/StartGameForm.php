<?php


namespace rain1208\onigame\game\form;

use pocketmine\form\Form;
use pocketmine\form\FormValidationException;
use pocketmine\Player;
use rain1208\onigame\GamePlayer;
use rain1208\onigame\Main;

class StartGameForm implements Form
{
    /** @var GamePlayer[] */
    private $players;

    private $maps;

    public function handleResponse(Player $player, $data): void
    {
        $player->sendMessage($this->maps[$data[0]]);
        $player->sendMessage($this->players[$data[2]]->getName());
        Main::getInstance()->getGame()->setMap($this->maps[$data[0]]);
        $this->players[$data[2]]->setOni();
        Main::getInstance()->startGame();
    }

    public function jsonSerialize()
    {
        return [
            "type" => "custom_form",
            "title" => "ゲームスタート",
            "content" => [
                [
                    "type" => "dropdown",
                    "text" => "ゲームをするマップ",
                    "options" => array_keys($this->getMaps()),
                    "default" => 0
                ],
                [
                    "type" => "toggle",
                    "text" => "マップの選択をランダムにする",
                    "default" => false
                ],
                [
                    "type" => "dropdown",
                    "text" => "鬼の選択",
                    "options" => $this->getPlayers(),
                    "default" => 0
                ],
                [
                    "type" => "toggle",
                    "text" => "鬼をランダムに選択する",
                    "default" => false
                ]
            ]
        ];
    }

    private function getPlayers(): array
    {
        return array_map(
            function (Player $player) { return $player->getName(); },
            $this->players = Main::getInstance()->getGame()->getPlayingPlayer()
        );
    }

    private function getMaps(): array
    {
        return $this->maps = Main::getInstance()->getMapManager()->getAllMap();
    }
}
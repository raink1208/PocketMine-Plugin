<?php


namespace rain1208\policeSystem\Form;


use pocketmine\form\Form;
use pocketmine\level\Position;
use pocketmine\Player;
use pocketmine\Server;

class policeForm implements Form
{
    /**
     * @var array
     */
    private static $players;
    public function __construct(array $players)
    {
        /**
         * @var Player $player
         */
        self::$players = [];
        foreach ($players as $player) {
            self::$players[] = $player->getName();
        }
    }

    /**
     * @inheritDoc
     */
    public function handleResponse(Player $player, $data): void
    {
        if ($data === null || $data[1] === null) {
            return;
        }

        if ($data[0]) {
            $player->setGamemode(3, false);
            $player->sendMessage("スペクテイターにしました");
        } else {
            $player->setGamemode(0,false);
            $player->sendMessage("サバイバルにしました");
        }

        $ppos = Server::getInstance()->getPlayer(self::$players[$data[1]])->getPosition();
        $pos = new Position($ppos->getX(),$ppos->getY(),$ppos->getZ(),$ppos->getLevel());

        $player->teleport($pos);
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'type' => 'custom_form',
            'title' => 'police UI',
            'content' => [
                [
                    'type' => 'toggle',
                    'text' => 'スペクテイター',
                    'default' => true
                ],
                [
                    'type' => 'dropdown',
                    'text' => 'tpするプレイヤー',
                    'options' => self::$players,
                    'default' => 0
                ]
            ]
        ];
    }
}
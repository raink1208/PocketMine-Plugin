<?php


namespace rain1208\policeSystem\Form;


use pocketmine\form\Form;
use pocketmine\level\Position;
use pocketmine\Player;
use pocketmine\Server;

class tpForm implements Form
{
    /**
     * @var array
     */
    private static $players;

    public function __construct(Array $players)
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
        if ($data === null) {
            return;
        }
        $ppos = Server::getInstance()->getPlayer(self::$players[$data[0]])->getPosition();
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
            'title' => 'tpForm(police専用)',
            'content' => [
                [
                    'type' => 'dropdown',
                    'text' => 'tpするプレイヤーを選んでください',
                    'options' => self::$players
                ]
            ]
        ];
    }
}
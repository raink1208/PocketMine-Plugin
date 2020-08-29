<?php


namespace rain1208\poker;


use pocketmine\Player;

class PokerGame
{
    private $gameName;

    /** @var Decks */
    private $decks;
    private $players;
    private $minBet;

    private $game = false;

    public function __construct(string $name, int $minBet)
    {
        var_dump($name.":".$minBet);
        $this->gameName = $name;
        $this->minBet = $minBet;
    }

    public function getName(): string
    {
        return $this->gameName;
    }

    public function initGame(): void
    {
        $this->decks = new Decks();
    }

    public function joinGame(Player $player): void
    {
        if ($this->game) {
            $player->sendMessage("ゲームが開始しているので参加できません");
        }
        $this->players[$player->getName()] = $player;
    }

    public function startGame(): void
    {
        if (count($this->players) >= 1) {
            $this->initGame();
            $this->game = true;
        }
    }
}
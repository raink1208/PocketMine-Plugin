<?php


namespace rain1208\onigame\game;


class GameTask
{
    private $game;
    public function __construct(Game $game)
    {
        $this->game = $game;
    }
}
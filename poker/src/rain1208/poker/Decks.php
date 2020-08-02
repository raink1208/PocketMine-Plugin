<?php


namespace rain1208\poker;


class Decks
{
    private $decks;
    public function __construct()
    {
        $mark = ["♥","♦","♧","♤"];
        for ($j = 0; $j <= 3; $j++) {
            for ($i = 1; $i <= 13; $i++) {
                $deckCards[] = "${mark[$j]} $i";
            }
        }
        $deckCards[] = "joker";
        $this->decks = $deckCards;
    }

    public function DrawCards(): string
    {
        shuffle($this->decks);
        return array_shift($this->decks);
    }
}
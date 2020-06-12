<?php


namespace rain1208\onigame\map\form;


use pocketmine\form\Form;
use pocketmine\form\FormValidationException;
use pocketmine\Player;

class MainMapForm implements Form
{
    public function handleResponse(Player $player, $data): void
    {
        // TODO: Implement handleResponse() method.
    }

    public function jsonSerialize()
    {
        return [

        ];
    }
}
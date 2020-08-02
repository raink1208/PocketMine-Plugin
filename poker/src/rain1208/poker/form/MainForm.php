<?php


namespace rain1208\poker\form;


use pocketmine\form\Form;
use pocketmine\form\FormValidationException;
use pocketmine\Player;

class MainForm implements Form
{
    private $form;

    public function __construct(Player $player)
    {
        $this->form = [
            "type" => "form",
            "title" => "Poker Menu",
            "content" => "操作を選んでください",
            "buttons" => [
                ["text" => "Create Game"],
                ["text" => "Join Game"],
                ["text" => "Leave Game"],
                ["text" => "Rule"]
            ]
        ];
        if ($player->isOp()) {
            array_push($this->form["buttons"],["text" => "Edit Game"]);
        }
    }

    public function handleResponse(Player $player, $data): void
    {
        if ($data === null) return;
        switch ($data) {
            case 0:
                $player->sendForm(new CreateGameForm());
            case 1:

        }
    }

    public function jsonSerialize()
    {
        return $this->form;
    }
}
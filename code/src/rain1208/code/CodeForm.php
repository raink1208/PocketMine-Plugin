<?php


namespace rain1208\code;


use onebone\economyapi\EconomyAPI;
use pocketmine\form\Form;
use pocketmine\form\FormValidationException;
use pocketmine\item\Item;
use pocketmine\Player;

class CodeForm implements Form
{
    /** @var Main */
    private $main;

    public function __construct(Main $main)
    {
        $this->main = $main;
    }

    public function handleResponse(Player $player, $data): void
    {
        if ($data === null) return;
        if (count($data) <= 0) return;

        $config = $this->main->config;
        if ($config->exists($data[0])) {
            $give = $config->get($data[0]);
            if (count($give["item"]) >= 1) {
                $id = $give["item"][0];
                $meta = $give["item"][1] ?? 0;
                $count = $give["item"][2] ?? 1;
                $item = new Item($id,$meta);
                $item->setCount($count);
                $player->getInventory()->addItem($item);
            }
            if ($give["money"] >= 1) {
                EconomyAPI::getInstance()->addMoney($player,$give["money"]);
            }
            $player->sendMessage("受け取りました");
            $config->remove($data[0]);
            $config->save();
        } else {
            $player->sendMessage("コードが違います");
        }
    }

    public function jsonSerialize()
    {
        return [
            "type" => "custom_form",
            "title" => "Code Form",
            "content" => [
                [
                    "type" => "input",
                    "text" => "コードを入力してください"
                ]
            ]
        ];
    }
}
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
        $received = $this->main->received;
        if ($config->exists($data[0])) {
            if (in_array($player->getName(),$received->get($data[0]))) {
                $player->sendMessage("あなたはすでに受け取っています");
                return;
            }
            $give = $config->get($data[0]);
            if (count($give["item"]) >= 1) {
                $id = $give["item"][0];
                $meta = $give["item"][1] ?? 0;
                $count = $give["item"][2] ?? 1;
                $item = new Item($id,$meta);
                $item->setCount($count);
                if ($player->getInventory()->canAddItem($item)) {
                    $player->getInventory()->addItem($item);
                }
            }
            if ($give["money"] >= 1) {
                EconomyAPI::getInstance()->addMoney($player,$give["money"]);
            }
            $player->sendMessage("受け取りました");
            $list = $received->get($data[0]);
            $list[] = $player->getName();
            $received->set($data[0],$list);
            $received->save();
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
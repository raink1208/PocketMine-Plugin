<?php


namespace rain1208\code;


use pocketmine\form\Form;
use pocketmine\form\FormValidationException;
use pocketmine\Player;

class AddCodeForm implements Form
{
    /** @var Main */
    private $main;

    private $template = ["item" => [],"money" => 1000];

    public function __construct(Main $main)
    {
        $this->main = $main;
    }

    private function setItem(int $id,int $meta,int $count): void
    {
        $this->template["item"] = [$id,$meta,$count];
    }

    private function setMoney(int $amount): void
    {
        $this->template["money"] = $amount;
    }

    public function handleResponse(Player $player, $data): void
    {
        if ($data === null) return;
        if (count($data) <= 0) return;

        if ($data[1] !== null && $data[1] !== "") {
            $item = explode(":",$data[1]);
            $id = $item[0];
            $meta = $item[1] ?? 0;
            $count = $item[2] ?? 1;
            $this->setItem($id,$meta,$count);
        }

        if ($data[2] !== null && is_numeric($data[2])) {
            $this->setMoney($data[2]);
        }

        if ($data[0] === null || $data[0] === "") return;
        $config = $this->main->config;
        $config->set($data[0],$this->template);
        $config->save();

        $player->sendMessage("コードを追加しました");
    }

    public function jsonSerialize()
    {
        return [
            "type" => "custom_form",
            "title" => "AddCode",
            "content" => [
                [
                    "type" => "input",
                    "text" => "コードを入力してください"
                ],
                [
                    "type" => "input",
                    "text" => "受け取るアイテム(何も渡さないときは書かない) \nItemID:meta:Count"
                ],
                [
                    "type" => "input",
                    "text" => "受け取る金額(渡さないときは書かない)"
                ]
            ]
        ];
    }
}
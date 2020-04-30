<?php


namespace rain1208\tags;


use Deceitya\MiningLevel\MiningLevelAPI;
use onebone\economyapi\EconomyAPI;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\tile\Sign;
use pocketmine\network\mcpe\protocol\ModalFormRequestPacket;
use pocketmine\network\mcpe\protocol\ModalFormResponsePacket;
use pocketmine\Player;
use pocketmine\utils\Config;

class tagShop implements Listener
{
    /** @var Config shopの位置の保存*/
    private static $shop;
    /** @var Config プレイヤーごとのタグの保存*/
    private static $tag;

    private $fid;
    private $prebuy = [];

    public static function loadConfig(Config $shop,Config $tag) {
        self::$shop = $shop;
        self::$tag = $tag;
    }
    public function onTap(PlayerInteractEvent $event) {
        $block = $event->getBlock();
        $blockID = $block->getId();
        if ($blockID === 63 || $blockID === 68) {
            $player = $event->getPlayer();
            $sign = $player->getLevel()->getTile($block);
            if (!($sign instanceof Sign)) return;
            $text = $sign->getText();
            $pos = $block->x.":".$block->y.":".$block->z;
            if ($text[0] === "[§btagshop§r]") {
                if (self::$shop->exists($pos)) {
                    $price = (int) str_replace("§6値段  : ", "",$text[2]);
                    $myMoney = EconomyAPI::getInstance()->myMoney($player);
                    if ($price <= $myMoney) {
                        $tag = str_replace("§f称号  : §r","", $text[1]);
                        $data = [
                            "type" => "modal",
                            "title" => "[§btagshop§r]",
                            "content" => "称号{$tag}§fを購入しますか?",
                            "button1" => "はい",
                            "button2" => "いいえ"
                        ];
                        $event->setCancelled();
                        $this->createWindow($player,$data);
                        $this->prebuy[$player->getName()] = [$tag,$price];
                    } else {
                        $event->setCancelled();
                        $player->sendMessage("お金が足りないのでキャンセルされました");
                    }
                }
            } elseif ($text[0] === "tagshop") {
                if ($player->isOp()) {
                    if (!empty($text[1]) && is_numeric($text[2])) {
                        $sign->setText("[§btagshop§r]","§f称号  : §r". $text[1], "§6値段  : " . $text[2],$text[3]);
                        self::$shop->set($pos);
                        self::$shop->save();
                        $player->sendMessage("[§btagshop§r] 称号ショップを作成しました");
                    } else {
                        $player->sendMessage("[§btagshop§r] 書き方が違います");
                        $sign->setText("tagshop","称号","値段","コメント");
                    }
                }
            }
        }
    }

    public function onBreak(BlockBreakEvent $event) {
        $block = $event->getBlock();
        $blockID = $block->getId();
        if ($blockID === 63 || $blockID === 68) {
            $player = $event->getPlayer();
            $sign = $player->getLevel()->getTile($block);
            if (!($sign instanceof Sign)) return;
            $text = $sign->getText();
            if ($text[0] === "[§btagshop§r]") {
                $pos = $block->x.":".$block->y.":".$block->z;
                if (self::$shop->exists($pos)) {
                    if ($player->isOp()) {
                        self::$shop->remove($pos);
                        self::$shop->save();
                        $player->sendMessage("ショップを撤去しました");
                    } else {
                        $event->setCancelled();
                        $player->sendMessage("op出ないため壊せません");
                    }
                }
            }
        }
    }

    private function createWindow(Player $player,$data) {
        $this->fid = mt_rand(0,999999);
        $pk = new ModalFormRequestPacket();
        $pk->formId = $this->fid;
        $pk->formData = json_encode($data,JSON_PRETTY_PRINT | JSON_BIGINT_AS_STRING | JSON_UNESCAPED_UNICODE);
        $player->dataPacket($pk);
    }

    public function onReceive(DataPacketReceiveEvent $event) {
        $pk = $event->getPacket();
        if ($pk instanceof ModalFormResponsePacket) {
            if ($pk->formId === $this->fid) {
                $data = $pk->formData;
                if ($data === "true\n") {
                    $player = $event->getPlayer();
                    $name = $player->getName();
                    $tag = $this->prebuy[$name][0];
                    $price = $this->prebuy[$name][1];
                    self::$tag->set($name,$tag);
                    self::$tag->save();
                    EconomyAPI::getInstance()->reduceMoney($player,$price);
                    $level = MiningLevelAPI::getInstance()->getLevel($player);
                    setTag::loadTags(self::$tag);
                    new setTag($player,$level);
                    $player->sendMessage("[§btagshop§r]"."あなたに".$tag."を付けました");
                    unset($this->prebuy[$name]);
                }
            }
        }
    }
}
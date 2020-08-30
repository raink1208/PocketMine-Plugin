<?php

namespace rain1208\tennis;

use pocketmine\entity\Entity;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\item\ItemIds;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\Player;

class EventListener implements Listener
{
    public function onBreak(BlockBreakEvent $event)
    {
        $player = $event->getPlayer();
        $hand = $player->getInventory()->getItemInHand();
        if ($hand->getCustomName() === "テニスボール") $event->setCancelled();
        if ($hand->getCustomName() === "ラケット") $event->setCancelled();
    }

    public function onDamage(EntityDamageEvent $event)
    {
        if ($event->getEntity() instanceof SlimeBall) $event->setCancelled();
    }

    public function onDropItem(PlayerDropItemEvent $event)
    {
        if ($event->getItem()->getId() === ItemIds::SLIME_BALL &&
            $event->getItem()->getCustomName() === "テニスボール") {
            $player = $event->getPlayer();
            $ball = Entity::createEntity("ball",$player->getLevelNonNull(),Entity::createBaseNBT($player));
            if ($ball instanceof Entity) {
                $ball->spawnToAll();
                $ball->move(0,25,0);
            }
            $event->setCancelled();
        }
    }

    public function shot(Player $player,$pitch,$multiply)
    {
        $pos = (new Vector3($player->getX(),$player->getY(),$player->getZ()))->add(0,1.2,0);
        foreach ($player->getLevel()->getEntities() as $ball) {
            if (!$ball instanceof SlimeBall) continue;
            if ($pos->distance($ball) >= 2.2) continue;
            $aimPos = new Vector3(
                -sin($player->yaw / 180 * M_PI) * cos($pitch / 180 * M_PI),
                -sin($pitch / 180 * M_PI),
                cos($player->yaw / 180 * M_PI) * cos($pitch / 180 * M_PI)
            );
            $ball->setMotion($aimPos->multiply($multiply));
        }
    }

    public function onSound(DataPacketReceiveEvent $event)
    {
        $player = $event->getPlayer();
        $packet = $event->getPacket();
        if (!$packet instanceof LevelSoundEventPacket) return;
        if ($packet->sound >= LevelSoundEventPacket::SOUND_ATTACK &&
            $packet->sound <= LevelSoundEventPacket::SOUND_ATTACK_STRONG or
            $packet->sound === LevelSoundEventPacket::SOUND_HIT) {
            $hand = $player->getInventory()->getItemInHand();
            if ($hand->getId() === ItemIds::SLIME_BALL && $hand->getCustomName() === "テニスボール") {
                $player = $event->getPlayer();
                $ball = Entity::createEntity("ball",$player->getLevelNonNull(),Entity::createBaseNBT($player));
                if ($ball instanceof Entity) {
                    $ball->spawnToAll();
                    $ball->move(0,25,0);
                }
                $event->setCancelled();
            }
            if ($hand->getId() !== ItemIds::STICK) return;
            if ($player->isSneaking()) {
                $this->shot($player,-26,1.75); //ドロップ
            } else {
                $this->shot($player,1.5,2.5); //スマッシュ
            }
        }
    }

    public function onUse(PlayerInteractEvent $event)
    {
        if ($event->getAction() !== $event::RIGHT_CLICK_BLOCK and $event->getAction() !== $event::RIGHT_CLICK_AIR) return;
        $player = $event->getPlayer();
        $hand = $player->getInventory()->getItemInHand();
        if ($hand->getId() === ItemIds::SLIME_BALL && $hand->getCustomName() === "テニスボール") {
            $player = $event->getPlayer();
            $ball = Entity::createEntity("ball",$player->getLevelNonNull(),Entity::createBaseNBT($player));
            if ($ball instanceof Entity) {
                $ball->spawnToAll();
                $ball->move(0,25,0);
            }
            $event->setCancelled();
        }
        if ($hand->getId() !== ItemIds::STICK) return;
        if ($player->isSneaking()) {
            $this->shot($player,-60,2.2); //ロブ
        } else {
            $this->shot($player,-17,2.3); //ドライブ
        }
        $event->setCancelled();
    }
}
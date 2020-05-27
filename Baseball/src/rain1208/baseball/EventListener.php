<?php


namespace rain1208\baseball;

use pocketmine\entity\Entity;
use pocketmine\entity\projectile\Snowball;
use pocketmine\event\entity\ProjectileHitEntityEvent;
use pocketmine\event\entity\ProjectileHitEvent;
use pocketmine\event\entity\ProjectileLaunchEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerToggleSneakEvent;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\Player;



class EventListener implements Listener
{
    /** @var Snowball */
    private $ball;

    public function onHit(PlayerToggleSneakEvent $event) {
        if ($event->isSneaking()) {
            return;
        }
        $player = $event->getPlayer();
        $hand = $player->getInventory()->getItemInHand();
        if ($hand->getId() === 280 && isset($this->ball) && $hand->getCustomName() === "バット") {
            $ballpos = $this->ball->getPosition();
            $p = $player->getPosition();
            $p->add(0,1,0);
            if ($p->distance($ballpos) <= 2.5) {
                $this->ball->kill();
                $this->ball = null;
                $pos = $player->getPosition();

                $aimPos = new Vector3(
                    -sin($player->yaw / 180 * M_PI) * cos($player->pitch / 180 * M_PI),
                    -sin($player->pitch / 180 * M_PI),
                    cos($player->yaw / 180 * M_PI) * cos($player->pitch / 180 * M_PI)
                );
                $nbt = new CompoundTag("", [
                    "Pos" => new ListTag("Pos", [
                        new DoubleTag("", $pos->x),
                        new DoubleTag("", $pos->y + $player->getEyeHeight()),
                        new DoubleTag("", $pos->z)
                    ]),
                    "Motion" => new ListTag("Motion", [
                        new DoubleTag("", $aimPos->x),
                        new DoubleTag("", $aimPos->y),
                        new DoubleTag("", $aimPos->z)
                    ]),
                    "Rotation" => new ListTag("Rotation", [
                        new FloatTag("", $player->yaw),
                        new FloatTag("", $player->pitch)
                    ]),
                ]);
                $f = 1.5;
                $snowball = Entity::createEntity("Snowball", $player->getLevel(), $nbt, $player);
                $snowball->setMotion($snowball->getMotion()->multiply($f));
                $snowball->spawnToAll();
            }
        }
    }

    public function onLaunchProjectile(ProjectileLaunchEvent $event) {
        if ($event->getEntity() instanceof Snowball) {
            $this->ball = $event->getEntity();
        }
    }

    public function onProjectileHit(ProjectileHitEvent $event) {
        $this->ball = null;
        $entity = $event->getEntity();
        if (!($entity instanceof Snowball)) {
            return;
        }
        if ($event instanceof ProjectileHitEntityEvent) {
            $player = $event->getEntityHit();
            if ($player instanceof Player) {
                 switch ($player->getInventory()->getItemInHand()->getId()) {
                     case 0:
                         $player->getInventory()->setItemInHand(new \pocketmine\item\Snowball(1));
                         break;
                 }
            }
        }

    }
}
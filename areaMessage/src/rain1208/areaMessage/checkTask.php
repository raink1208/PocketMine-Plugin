<?php


namespace rain1208\areaMessage;


use pocketmine\math\AxisAlignedBB;
use pocketmine\scheduler\Task;
use pocketmine\Server;

class checkTask extends Task
{
    public function onRun(int $currentTick)
    {
        foreach (Server::getInstance()->getOnlinePlayers() as $player) {
            $world = $player->getLevel()->getName();
            $position = Main::$db->getData($world);
            if ($position !== null) {
                foreach ($position as $pos) {
                    $x = explode(",",$pos[2]);
                    $y = explode(",",$pos[3]);
                    $z = explode(",",$pos[4]);
                    $aabb = new AxisAlignedBB($x[0],$y[0],$z[0],$x[1],$y[1],$z[1]);
                    if ($aabb->isVectorInside($player)) {
                        $player->addActionBarMessage($pos[5]);
                    }
                }
            }
        }
    }
}
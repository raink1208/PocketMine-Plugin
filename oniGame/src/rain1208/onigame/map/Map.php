<?php


namespace rain1208\onigame\map;


use pocketmine\level\Level;
use pocketmine\nbt\BigEndianNBTStream;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\Server;

class Map
{
    private $name;
    private $original;

    private $world;

    public function __construct(string $name ,Level $original)
    {
        $this->name = $name;
        $this->original = $original;
        $this->copyLevel();
    }

    /** @return Level */
    public function getOriginal(): Level
    {
        return $this->original;
    }

    /** @return Level */
    public function getWorld(): Level
    {
        return $this->world;
    }

    public function copyLevel():void
    {
        $from = $this->getOriginal()->getName();
        $copy = $from."copy";
        $frompath = Server::getInstance()->getDataPath()."worlds/".$from;
        $copypath = Server::getInstance()->getDataPath()."worlds/".$copy;
        if (is_dir($frompath)) return;
        $this->copy($frompath,$copypath);
        $nbt = new BigEndianNBTStream();
        $worldData = $nbt->readCompressed(file_get_contents($copypath."/level.dat"));
        $data = $worldData->getCompoundTag("Data");
        $data->setString("LevelName",$copy);
        file_put_contents($copypath."/level.dat",$nbt->writeCompressed(new CompoundTag("",array($data))));
        Server::getInstance()->loadLevel($copy);
        $this->world = Server::getInstance()->getLevelByName($copy);
    }

    private function copy(string $from,string $copy)
    {
        if (!is_dir($from)) return;
        $objs = scandir($from);
        mkdir($copy);
        foreach ($objs as $obj) {
            if ($obj !== "." && $obj !== "..") {
                if (is_dir($from."/".$obj)) {
                    $this->copy($from."/".$obj,$copy."/".$obj);
                } else {
                    copy($from . "/" . $obj, $copy . "/" . $obj);
                }
            }
        }
    }
}
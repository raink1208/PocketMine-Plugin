<?php


namespace rain1208\onigame\command;


use pocketmine\command\PluginCommand;
use pocketmine\plugin\Plugin;

class StartOni extends PluginCommand
{
    public function __construct(Plugin $owner)
    {
        parent::__construct("startoni", $owner);
    }
}
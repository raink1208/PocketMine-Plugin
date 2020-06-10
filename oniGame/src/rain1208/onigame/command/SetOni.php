<?php


namespace rain1208\onigame\command;


use pocketmine\command\PluginCommand;
use pocketmine\plugin\Plugin;

class SetOni extends PluginCommand
{
    public function __construct(Plugin $owner)
    {
        parent::__construct("setoni", $owner);

        $this->setDescription("鬼を設定します");
    }
}
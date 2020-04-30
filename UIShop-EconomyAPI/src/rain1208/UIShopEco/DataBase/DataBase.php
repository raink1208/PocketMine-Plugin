<?php


namespace rain1208\UIShopEco\DataBase;


use pocketmine\plugin\Plugin;
use SQLite3;

class DataBase
{
    /** @var SQLite3 */
    private $db;

    public function __construct(Plugin $plugin)
    {
        $file = $plugin->getDataFolder()."shop.db";
        if (file_exists($file)) {
            $this->db = new SQLite3($file,SQLITE3_OPEN_READWRITE);
        } else {
            $this->db = new SQLite3($file,SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
        }

        $this->db->exec(
            'CREATE TABLE IF NOT EXISTS shop('.
            'item TEXT NOT NULL PRIMARY KEY,'.
            'cat TEXT NOT NULL,'.
            'price INTEGER NOT NULL)'
        );
    }


}
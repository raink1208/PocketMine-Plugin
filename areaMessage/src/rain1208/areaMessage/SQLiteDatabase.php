<?php


namespace rain1208\areaMessage;


use SQLite3;

class SQLiteDatabase
{
    private $db;

    public function __construct(Main $plugin)
    {
        $file = $plugin->getDataFolder()."config.db";
        if (file_exists($file)) {
            $this->db = new SQLite3($file,SQLITE3_OPEN_READWRITE);
        } else {
            $this->db = new SQLite3($file,SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
        }

        $this->db->exec("CREATE TABLE IF NOT EXISTS config".
            "(name TEXT NOT NULL PRIMARY KEY,".
            " world TEXT NOT NULL,".
            " posX TEXT NOT NULL,".
            " posY TEXT NOT NULL,".
            " posZ TEXT NOT NULL,".
            " message TEXT NOT NULL)"
        );
    }

    public function createAreaMessage(string $name,string $world,string $posX,string $posY,string $posZ,string $message) {
        $stmt = $this->db->prepare("INSERT INTO config(name, world, posX, posY, posZ, message) VALUES (:name, :world, :posX, :posY, :posZ, :message)");
        $stmt->bindValue(":name",$name,SQLITE3_TEXT);
        $stmt->bindValue(":world",$world,SQLITE3_TEXT);
        $stmt->bindValue(":posX",$posX,SQLITE3_TEXT);
        $stmt->bindValue(":posY",$posY,SQLITE3_TEXT);
        $stmt->bindValue(":posZ",$posZ,SQLITE3_TEXT);
        $stmt->bindValue(":message",$message,SQLITE3_TEXT);
        $stmt->execute();
    }

    public function getData($world):array {
        $stmt = $this->db->query("SELECT * FROM config WHERE world = '$world'");
        $result = [];
        while ($res = $stmt->fetchArray(2)) {
            array_push($result,$res);
        }
        return $result;
    }
    public function getName():array {
        $stmt = $this->db->query("SELECT name FROM config");
        $result = [];
        while ($res = $stmt->fetchArray(1)) {
            array_push($result,$res);
        }
        return $result;
    }
    public function getDataByName(string $name):array {
        $stmt = $this->db->query("SELECT * FROM config");
        $result = $stmt->fetchArray(SQLITE3_ASSOC);
        return $result === false? null : $result;
    }
    public function changeMessage(string $name,string $message) {
        $stmt = $this->db->prepare("UPDATE config SET message = '$message' WHERE name = '$name'");
        $stmt->execute();
    }
    public function removeArea(string $name) {
        $stmt = $this->db->prepare("DELETE FROM config WHERE name = :name");
        $stmt->bindValue(":name",$name,SQLITE3_TEXT);
        $stmt->execute();
    }
}
<?php


namespace App\models;


use App\lib\Config;
use App\lib\Model;

class File extends Model
{

    public function create($path)
    {
        $sql = "insert into files (path)
            VALUES (:path)";
        $pdoStm = $this->db->prepare($sql);
        $pdoStm->bindValue(':path', $path, \PDO::PARAM_STR);
        $pdoStm->execute();
        return $this->db->lastInsertId();
    }

    public static function getNoImageId()
    {
        return Config::get('defaultImageId');
    }
}
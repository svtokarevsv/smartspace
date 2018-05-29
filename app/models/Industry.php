<?php
/**
 * Created by PhpStorm.
 * User: baong
 * Date: 2018-04-10
 * Time: 2:28 AM
 */

namespace App\models;

use App\lib\model;
use App\lib\App;

class Industry extends model
{
    public function getAll()
    {
        $sql = "SELECT * FROM industries";
        $stm = $this->db->prepare($sql);
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_OBJ);
    }
    public function getIndustriesById($id) {
        $sql = "SELECT * FROM industries WHERE id = :id";
        $stm = $this->db->prepare($sql);
        $stm->bindValue(':id', $id, \PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(\PDO::FETCH_OBJ);
    }
}
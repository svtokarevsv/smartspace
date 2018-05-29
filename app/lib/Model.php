<?php

namespace App\lib;
class Model
{
    protected $db;

    public function __construct()
    {
        $this->db = App::$db;
    }

   /* // show all example
    public function getAll()
    {
        $sql = "SELECT * FROM table_name";
        $stm = $this->db->prepare($sql);
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $stm->execute();
        return $stm->fetchAll();
    }

    // find by id example
    public function getById($id)
    {
        $sql = "SELECT * FROM table_name WHERE id = :id";
        $stm = $this->db->prepare($sql);
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $stm->bindParam(':id', $id);
        $stm->execute();
        return $stm->fetch();
    }


    // create example
    public function create($value)
    {
        $sql = "INSERT INTO table_name(column_name) VALUES(:value)";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(':value', $value);
        return $stm->execute();
    }

    //update example
    public function update($id, $value)
    {
        $sql = "UPDATE table_name SET column_name = :value WHERE id= :id";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(':id', $id);
        $stm->bindParam(':value', $value);
        return $stm->execute();
    }

    //delete example
    public function delete($id)
    {
        $stm = $this->db->prepare("DELETE FROM table_name WHERE id = :id");
        $stm->bindParam(':id', $id);
        return $stm->execute();
    }
    */
}

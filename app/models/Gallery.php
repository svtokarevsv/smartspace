<?php


namespace App\models;


use App\lib\App;
use App\lib\Config;
use App\lib\Model;

class Gallery extends Model
{
    //read
    public function getAll()
    {
        $sql = "SELECT * FROM galleries";
        $stm = $this->db->prepare($sql);
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $stm->execute();
        return $stm->fetchAll();
    }

    public function add_image( $creator_id,$image_title, $image_id)
    {
        $sql = 'INSERT INTO galleries (creator_id,image_title,image_id)
            VALUES (:creator_id,:image_title,:image_id)';
        $pdoStm = $this->db->prepare($sql);
        $pdoStm->bindValue(':creator_id', $creator_id, \PDO::PARAM_INT);
        $pdoStm->bindValue(':image_title', $image_title, \PDO::PARAM_STR);
        $pdoStm->bindValue(':image_id', $image_id, \PDO::PARAM_INT);
        $pdoStm->execute();
        return $this->db->lastInsertId();
    }

    public function getGalleryImagesByUserId($creator_id)
    {
        $sql = "SELECT g.*,f.path AS 'image_path' FROM galleries g 
                JOIN files f 
                ON g.image_id=f.id
                WHERE g.creator_id=:creator_id";
        $stm = $this->db->prepare($sql);
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $stm->bindParam(':creator_id', $creator_id);
        $stm->execute();
        return $stm->fetchAll();
    }

    public function delete_image_by_id($id)
    {
        $stm = $this->db->prepare('DELETE FROM galleries WHERE id = :id');
        $stm->bindParam(':id', $id);
        return $stm->execute();
    }
}
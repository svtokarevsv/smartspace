<?php

namespace App\models;

use App\lib\Config;
use App\lib\Model;

class Comment extends Model
{
    //read
    public function getCommentsByPostId($post_id,$page)
    {
        $per_page = Config::get('comments_per_page');
        $from_page = $per_page * $page;
        $number_to_select = $per_page;
        $sql = "SELECT c.*,concat(u.first_name, ' ',  u.last_name) as 'user_name',u.id as 'user_id',
                fu.path as 'userimg_path' ,f.path as 'image_path'  from comments c
                join posts p 
                on p.id=c.post_id
                left join files f 
                ON c.image_id = f.id  
                join users u 
                on c.creator_id = u.id 
                left join files fu 
                on u.avatar_id = fu.id
                WHERE post_id=:post_id
                ORDER BY creation_date Desc
                LIMIT :from_page,:number_to_select";
        $stm = $this->db->prepare($sql);
        $stm->bindValue(':post_id', $post_id, \PDO::PARAM_INT);
        $stm->bindValue(':from_page', $from_page, \PDO::PARAM_INT);
        $stm->bindValue(':number_to_select', $number_to_select, \PDO::PARAM_INT);
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $stm->execute();
        return $stm->fetchAll();
    }

    public function create($message,$image_id,$post_id, $creator_id)
    {
        $sql = 'insert into comments (message,image_id,post_id, creator_id)
            VALUES (:message,:image_id, :post_id,:creator_id)';
        $pdoStm = $this->db->prepare($sql);
        $pdoStm->bindValue(':message', $message, \PDO::PARAM_STR);
        $pdoStm->bindValue(':image_id', $image_id, \PDO::PARAM_INT);
        $pdoStm->bindValue(':post_id', $post_id, \PDO::PARAM_INT);
        $pdoStm->bindValue(':creator_id', $creator_id, \PDO::PARAM_INT);
        $pdoStm->execute();
        return $this->db->lastInsertId();
    }

}
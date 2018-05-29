<?php
/**
 * Created by PhpStorm.
 * User: Gurinder
 * Date: 2018-04-03
 * Time: 2:06 AM
 */

namespace App\models;

use App\lib\App;
use App\lib\Config;
use App\lib\Model;

class Post extends Model
{
    //to get all posts of logged in admin
    public function getAll($page,$creator_id)
    {
        $per_page = Config::get('per_page');
        $from_page = $per_page * $page;
        $number_to_select = $per_page;
        $sql = "SELECT p.*,concat(u.first_name, ' ',  u.last_name) as 'user_name',u.id as 'user_id',fu.path as 'userimg_path' ,f.path as 'image_path' 
                FROM posts p 
                left join files f 
                ON p.image_id = f.id  
                join users u 
                on p.creator_id = u.id 
                left join files fu 
                on u.avatar_id = fu.id
                WHERE p.creator_id = :creator_id
                ORDER BY creation_date Desc
                 LIMIT :from_page,:number_to_select";
        $stm = $this->db->prepare($sql);
        $stm->bindValue(':creator_id', $creator_id, \PDO::PARAM_INT);
        $stm->bindParam(':from_page', $from_page, \PDO::PARAM_INT);
        $stm->bindParam(':number_to_select', $number_to_select, \PDO::PARAM_INT);
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $stm->execute();
        return $stm->fetchAll();
    }
    //to get all posts of friends and loggin admin
    public function getAllFeed($current_user_id, $page)
    {
        $per_page = Config::get('per_page');
        $from_page = $per_page * $page;
        $number_to_select = $per_page;
        $sql = "SELECT p.*,concat(u.first_name, ' ', u.last_name) AS 'user_name',
                u.id as 'user_id',fu.path AS 'userimg_path' ,  f.path AS 'image_path'
                FROM posts p 
                LEFT JOIN files f 
                ON p.image_id = f.id 
                JOIN users u 
                ON p.creator_id = u.id 
                LEFT JOIN files fu 
                ON u.avatar_id = fu.id 
                WHERE p.creator_id in(SELECT user1_id from friends WHERE user2_id=:current_user_id)
                OR  p.creator_id in(SELECT user2_id from friends WHERE user1_id=:current_user_id)
                OR p.creator_id=:current_user_id
                ORDER BY creation_date DESC
                LIMIT :from_page,:number_to_select";


        $stm = $this->db->prepare($sql);
        $stm->bindValue(':current_user_id', $current_user_id, \PDO::PARAM_INT);
        $stm->bindParam(':from_page', $from_page, \PDO::PARAM_INT);
        $stm->bindParam(':number_to_select', $number_to_select, \PDO::PARAM_INT);
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $stm->execute();
        return $stm->fetchAll();
    }
    //to get posts by id to edit or delete
    public function getPostById(int $id)
    {
        $sql = "SELECT p.*,concat(u.first_name, ' ',  u.last_name) as 'user_name',u.id as 'user_id',
                fu.path as 'userimg_path',f.path as 'image_path' 
                FROM posts p 
                left join files f 
                ON p.image_id = f.id  
                join users u 
                on p.creator_id = u.id 
                left join files fu 
                on u.avatar_id = fu.id 
                WHERE p.id = :id";
        $stm = $this->db->prepare($sql);
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $stm->bindParam(':id', $id);
        $stm->execute();
        return $stm->fetch();
    }
//get posts based on group id
    public function get_posts_by_group_id(int $group_id)
    {
        $sql = "SELECT p.*,concat(u.first_name, ' ',  u.last_name) as 'user_name',
                fu.path as 'userimg_path' ,f.path as 'image_path' 
                FROM posts p 
                left join files f 
                ON p.image_id = f.id  
                join users u 
                on p.creator_id = u.id 
                left join files fu 
                on u.avatar_id = fu.id
                WHERE group_id = :group_id
                ORDER BY id DESC";
        $stm = $this->db->prepare($sql);
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $stm->bindParam(':group_id', $group_id);
        $stm->execute();
        return $stm->fetchAll();
    }

    //create new post
    public function createPost($post_message,$image_id ,$creator_id,$group_id=null)
    {
        $sql = "insert into posts (post_message,image_id, creator_id,group_id)
            VALUES (:post_message,:image_id, :creator_id,:group_id)";
        $pdoStm = $this->db->prepare($sql);
        $pdoStm->bindValue(':post_message', $post_message, \PDO::PARAM_STR);
        $pdoStm->bindValue(':image_id', $image_id, \PDO::PARAM_INT);
        $pdoStm->bindValue(':creator_id', $creator_id, \PDO::PARAM_INT);
        $pdoStm->bindValue(':group_id', $group_id, \PDO::PARAM_INT);
        $pdoStm->execute();
        return $this->db->lastInsertId();
    }

    //update posts by id
    public function updatePostById($id, $post_message,$file_id=null)
    {
        $sql = "UPDATE posts SET post_message = :post_message";
        if($file_id){
            $sql.=",
                image_id=:image_id ";
        }
        $sql.=" WHERE id=:id";
        $stm = $this->db->prepare($sql);
        $stm->bindValue(':post_message', $post_message, \PDO::PARAM_STR);
        if($file_id){
            $stm->bindValue(':image_id', $file_id, \PDO::PARAM_INT);
        }

        $stm->bindValue(':id', $id, \PDO::PARAM_INT);
        return $stm->execute();
    }
    //delete posts by id
    public function deletePostById($id)
    {
        $sql = "DELETE FROM posts WHERE id=:id";

        $stm = $this->db->prepare($sql);
        $stm->bindValue(':id', $id, \PDO::PARAM_INT);
        return $stm->execute();
    }

 /*   public function deletePost($id){

        $query = "DELETE FROM posts WHERE id= :id" ;
        $pdostm = $this->db->prepare($query);
        $pdostm->bindValue(':id',$id, PDO::PARAM_INT);
        $count = $pdostm->execute();
        return $count;
    }*/
    //get posts of friends
    public function getFriendsPosts($current_user_id,$number)
    {
        $sql = "SELECT p.*,concat(u.first_name, ' ', u.last_name) AS 'user_name',u.id as 'user_id',
                fu.path AS 'userimg_path' ,  f.path AS 'image_path'
                FROM posts p 
            
                LEFT JOIN files f 
                ON p.image_id = f.id 
                JOIN users u 
                ON p.creator_id = u.id 
                LEFT JOIN files fu 
                ON u.avatar_id = fu.id 
                WHERE p.creator_id in(SELECT user1_id from friends WHERE user2_id=:current_user_id)
                OR  p.creator_id in(SELECT user2_id from friends WHERE user1_id=:current_user_id)
                ORDER BY creation_date DESC
                LIMIT :limit_number";
        $stm = $this->db->prepare($sql);
        $stm->bindValue(':current_user_id', $current_user_id, \PDO::PARAM_INT);
        $stm->bindValue(':limit_number', $number, \PDO::PARAM_INT);
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $stm->execute();
        return $stm->fetchAll();
    }

}
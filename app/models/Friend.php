<?php
/**
 * Created by PhpStorm.
 * User: Gurinder
 * Date: 2018-04-16
 * Time: 1:18 AM
 */

namespace App\models;

use App\lib\App;
use App\lib\Model;
use App\lib\Config;

class Friend extends Model
{
    //to get friends list of logged in user and loading 15 per page
    public function getAll($page, $creator_id)
    {
        $per_page = Config::get('per_page');
        $from_page = $per_page * $page;
        $number_to_select = $per_page;

        $sql = "SELECT fr.*,
                if(user1_id = :creator_id,concat(u.first_name,' ',u.last_name),concat(us.first_name, ' ' , us.last_name)) as 'frnd_name', 
                if(user1_id = :creator_id,f.path,fs.path) as 'frnd_image_path', 
                
                if(user1_id = :creator_id,user2_id,user1_id) as 'user_id', 
                if(user1_id = :creator_id,u.occupation, us.occupation) as 'frnd_occupation'
                FROM friends fr
                join users u on u.id = fr.user2_id
                join users us on us.id = fr.user1_id
                join files f 
                ON u.avatar_id = f.id 
                join files fs
                ON us.avatar_id = fs.id
	            WHERE user1_id = :creator_id xor user2_id = :creator_id
	             LIMIT :from_page,:number_to_select";

        $stm = $this->db->prepare($sql);
        $stm->bindValue(':creator_id', $creator_id, \PDO::PARAM_INT);
        $stm->bindParam(':from_page', $from_page, \PDO::PARAM_INT);
        $stm->bindParam(':number_to_select', $number_to_select, \PDO::PARAM_INT);
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $stm->execute();
        return $stm->fetchAll();
    }
    //get friends of friends
    public function getFriendsOfFriends($friend_id){
        $sql = "SELECT fr.*,
                if(user1_id = :friend_id,concat(us.first_name,' ',us.last_name),concat(u.first_name, ' ' , u.last_name)) as 'user_name', 
                if(user1_id = :friend_id,concat(u.first_name,' ',u.last_name),concat(us.first_name, ' ' , us.last_name)) as 'frnd_name', 
                if(user1_id = :friend_id,f.path,fs.path) as 'frnd_image_path', 
                if(user1_id = :friend_id,user2_id,user1_id) as 'frnd_id', 
                if(user1_id = :friend_id,u.occupation, us.occupation) as 'frnd_occupation'
                FROM friends fr
                join users u on u.id = fr.user2_id
                join users us on us.id = fr.user1_id
                join files f 
                ON u.avatar_id = f.id 
                join files fs
                ON us.avatar_id = fs.id
	            WHERE user1_id = :friend_id xor user2_id = :friend_id";

        $stm = $this->db->prepare($sql);
        $stm->bindValue(':friend_id', $friend_id, \PDO::PARAM_INT);
        $stm->setFetchMode(\PDO::FETCH_OBJ);
        $stm->execute();
        return $stm->fetchAll();
    }
    //to get friends of user using id of friend
    public function getFriendsById(int $id)
    {
        $sql = "SELECT * from friends 
                WHERE id = :id";
        $stm = $this->db->prepare($sql);
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $stm->bindParam(':id', $id);
        $stm->execute();
        return $stm->fetch();
    }
    //to delete or unfriend friend from list using id of friend
    public function deleteFriendById($id)
    {
        $sql = "DELETE FROM friends WHERE id=:id";

        $stm = $this->db->prepare($sql);
        $stm->bindValue(':id', $id, \PDO::PARAM_INT);
        return $stm->execute();
    }
    //to get all friend requests for logged in admin
    public function getFriendRequests($creator_id)
    {
        $sql = "SELECT fr.*, concat(uf.first_name,' ' ,uf.last_name) as 'sender_name', f.path as 'sender_image_path',  uf.id as 'sender_id'
                FROM friend_requests fr 
                JOIN users uf 
                ON uf.id = fr.request_from
                JOIN files f 
                ON uf.avatar_id = f.id
                WHERE request_to = :creator_id";
        $stm = $this->db->prepare($sql);
        $stm->bindValue(':creator_id', $creator_id, \PDO::PARAM_INT);
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $stm->execute();
        return $stm->fetchAll();

    }
    //to get friend request by id
    public function getRequestsById( $id) {
        $sql = "SELECT * from friend_requests
                WHERE id = :id";
        $stm = $this->db->prepare($sql);
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $stm->bindParam(':id', $id);
        $stm->execute();
        return $stm->fetch();
    }
    //to sent a friend request
    public function sendRequestById($creator_id,$user2_id){
        $sql = "INSERT INTO friend_requests (request_from,request_to)
            VALUES (:creator_id,:user2_id)";

        $stm = $this->db->prepare($sql);
        $stm->bindValue(':creator_id', $creator_id, \PDO::PARAM_INT);
        $stm->bindValue(':user2_id', $user2_id, \PDO::PARAM_INT);
        return $stm->execute();
    }
    //to decline friend request
    public function deleteRequestById($id) {
        $sql = "DELETE FROM friend_requests WHERE id=:id";

        $stm = $this->db->prepare($sql);
        $stm->bindValue(':id', $id, \PDO::PARAM_INT);
        return $stm->execute();
    }
    //get user id from friend request to accept request
    public function getUserByRequestID($id){
        $sql = "SELECT request_from from friend_requests
                WHERE id = :id";
        $stm = $this->db->prepare($sql);
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $stm->bindParam(':id', $id);
        $stm->execute();
        return $stm->fetchColumn();
    }
    //to accept the request and add friend to friends table
    public function addFriendToListById(int $user_id, int $user2_id)
    {
        $sql = "INSERT INTO friends (user1_id,user2_id)
            VALUES (:user_id,:user2_id)";
        $pdoStm = $this->db->prepare($sql);
        $pdoStm->bindValue(':user_id', $user_id, \PDO::PARAM_INT);
        $pdoStm->bindValue(':user2_id', $user2_id, \PDO::PARAM_INT);
        $pdoStm->execute();
        return $this->db->lastInsertId();
    }
    //search users in find friends page
    public function searchUsers($search_term,$page, $exclude_id)
    {
        $per_page=Config::get('per_page');
        $from_page=$per_page*$page;
        $number_to_select=$per_page;
        $sql = "SELECT u.id,concat(u.first_name, ' ',  u.last_name) AS 'user_name',
                avatars.path AS 'avatar_path',ctry.country,s.school_name,p.program_name,
                    (select count(id) from friends 
                    WHERE user2_id=u.id and user1_id=:exclude_id 
                    or user1_id=u.id and user2_id=:exclude_id ) 
                    AS isFriend,
                    (select count(id) from friend_requests WHERE 
                     request_from=:exclude_id and request_to=u.id
                     or request_from=u.id and request_to=:exclude_id) 
                    AS friendRequestSent
                FROM users u 
                LEFT JOIN files avatars 
                ON u.avatar_id=avatars.id
                LEFT JOIN cities cit
                ON u.city_id = cit.id
                LEFT JOIN countries ctry
                ON cit.country_id = ctry.id
                LEFT JOIN schools s 
                ON u.school_id = s.id
                LEFT JOIN programs p
                ON u.program_id = p.id
                WHERE u.id!=:exclude_id
                AND (concat(u.first_name, ' ',  u.last_name) LIKE :search_term 
                OR s.school_name LIKE :search_term 
                OR ctry.country LIKE :search_term 
                OR cit.city LIKE :search_term 
                OR p.program_name LIKE :search_term 
                OR u.display_email LIKE :search_term
                )                
                LIMIT :from_page,:number_to_select";
        $stm = $this->db->prepare($sql);
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $stm->bindParam(':exclude_id', $exclude_id, \PDO::PARAM_INT);
        $stm->bindParam(':from_page', $from_page, \PDO::PARAM_INT);
        $stm->bindParam(':number_to_select', $number_to_select, \PDO::PARAM_INT);
        $search_term="%$search_term%";
        $stm->bindParam(':search_term', $search_term, \PDO::PARAM_STR);
        $stm->execute();
        return $stm->fetchAll();
    }
}
<?php


namespace App\models;


use App\lib\App;
use App\lib\Config;
use App\lib\Model;

class UserLocation extends Model
{
    function updateUserLocation($user_id, $lat, $ln)
    {
        $sql = 'INSERT INTO user_locations(user_id,lat,ln) 
                VALUES(:user_id,:lat,:ln)
                ON DUPLICATE KEY UPDATE 
                lat=VALUES(lat),
                ln=VALUES(ln)
                ';
        $stm = $this->db->prepare($sql);
        $stm->bindParam(':user_id', $user_id, \PDO::PARAM_INT);
        $stm->bindParam(':lat', $lat, \PDO::PARAM_STR);
        $stm->bindParam(':ln', $ln, \PDO::PARAM_STR);
        return $stm->execute();
    }

    function getUserLocationById($user_id)
    {
        $sql = "SELECT * FROM user_locations WHERE user_id = :user_id";
        $stm = $this->db->prepare($sql);
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $stm->bindParam(':user_id', $user_id);
        $stm->execute();
        return $stm->fetch();
    }

    function getFriendsLocationByName($search_term, $owner_id)
    {
        $sql = "SELECT if(user1_id = :owner_id,concat(u.first_name,' ',u.last_name),
                concat(us.first_name, ' ' , us.last_name)) as 'label', 
                if(user1_id = :owner_id,f.path,fs.path) as 'image_path', 
                
                if(user1_id = :owner_id,user2_id,user1_id) as 'id', 
                if(user1_id = :owner_id,ul.lat,ul2.lat) as 'lat', 
                if(user1_id = :owner_id,ul.ln,ul2.ln) as 'ln', 
                if(user1_id = :owner_id,ul.last_updated,ul2.last_updated) as 'location_last_updated'
                FROM friends fr
                join users u on u.id = fr.user2_id
                join users us on us.id = fr.user1_id
                left join files f 
                ON u.avatar_id = f.id 
                left join files fs
                ON us.avatar_id = fs.id
                left join user_locations ul
                on u.id = ul.user_id
                left join user_locations ul2
                on us.id = ul2.user_id
	            WHERE (user1_id = :owner_id xor user2_id = :owner_id)
	            and if(user1_id = :owner_id,concat(u.first_name,' ',u.last_name),
                concat(us.first_name, ' ' , us.last_name)) LIKE :search_term";
        $stm = $this->db->prepare($sql);
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $search_term = "%$search_term%";
        $stm->bindParam(':owner_id', $owner_id);
        $stm->bindParam(':search_term', $search_term, \PDO::PARAM_STR);
        $stm->execute();
        return $stm->fetchAll();
    }

}
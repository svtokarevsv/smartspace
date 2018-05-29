<?php


namespace App\models;


use App\lib\Model;

class Message extends Model
{
    public function getMessages()
    {
        $sql = "SELECT * FROM messages";
        $stm = $this->db->prepare($sql);
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $stm->execute();
        return $stm->fetchAll();
    }

    public function createMessage($sender_id,$recepient_id,$message)
    {
        $sql = "insert into messages (sender_id, recepient_id, message)
            VALUES (:sender_id, :recepient_id, :message)";
        $pdoStm = $this->db->prepare($sql);
        $pdoStm->bindValue(':sender_id', $sender_id, \PDO::PARAM_INT);
        $pdoStm->bindValue(':recepient_id', $recepient_id, \PDO::PARAM_INT);
        $pdoStm->bindValue(':message', $message, \PDO::PARAM_STR);
        $pdoStm->execute();
        return $this->db->lastInsertId();
    }
    public function get_messages_with_contact_by_id($contact_id,$current_user_id)
    {
        $sql = "select concat(recepient.first_name,' ',recepient.last_name) as recepient_name,
                fr.path as recepient_avatar,
                recepient_id,
                concat(sender.first_name,' ',sender.last_name) as sender_name,
                fs.path as sender_avatar,
                sender_id,
                m.time,
                m.message
                from messages m
                JOIN users recepient
                on m.recepient_id = recepient.id
                JOIN users sender
                on m.sender_id = sender.id
                LEFT JOIN files fr 
                on recepient.avatar_id = fr.id
                LEFT JOIN files fs
                on sender.avatar_id = fs.id
                where (m.sender_id=:current_user_id and m.recepient_id=:contact_id) or 
                (m.sender_id=:contact_id and m.recepient_id=:current_user_id)
                ORDER BY m.time";
        $stm = $this->db->prepare($sql);
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $stm->bindParam(':current_user_id', $current_user_id, \PDO::PARAM_INT);
        $stm->bindParam(':contact_id', $contact_id, \PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll();
    }

    public function updateViewedMessages($sender_id,$receiver_id)
    {
        $sql = 'UPDATE messages SET viewed = 1 
                WHERE sender_id=:sender_id 
                AND recepient_id=:receiver_id 
                and viewed=0';
        $stm = $this->db->prepare($sql);
        $stm->bindParam(':sender_id', $sender_id, \PDO::PARAM_INT);
        $stm->bindParam(':receiver_id', $receiver_id, \PDO::PARAM_INT);
        return $stm->execute();
    }

    public function getCountUnviewedMessages($user_id)
    {
        $sql = 'SELECT count(id) FROM messages
                WHERE recepient_id=:user_id AND viewed=0';
        $stm = $this->db->prepare($sql);
        $stm->bindParam(':user_id', $user_id, \PDO::PARAM_INT);
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $stm->execute();
        return $stm->fetchColumn();
    }
    public function get_contact_list($current_user_id)
    {
        $sql = "select 
                IF(m.recepient_id = :current_user_id, concat(sender.first_name, ' ',  sender.last_name), 
                concat(recepient.first_name,' ',recepient.last_name)) as contact_name,
                IF(m.recepient_id = :current_user_id, sender.id,recepient.id) as contact_id,
                IF(m.recepient_id = :current_user_id, fs.path,fr.path) as contact_avatar_img,
                (select message from messages WHERE id=max(m.id)) as last_message,
                (select time from messages WHERE id=max(m.id)) as last_message_date,
                (select count(ms.id) from messages ms WHERE ms.recepient_id=:current_user_id and ms.sender_id=contact_id and 
                ms.viewed=0) as msgs_count
                from messages m
                JOIN users recepient
                on m.recepient_id = recepient.id
                JOIN users sender
                on m.sender_id = sender.id
                LEFT JOIN files fr 
                on recepient.avatar_id = fr.id
                LEFT JOIN files fs
                on sender.avatar_id = fs.id
                where m.sender_id=:current_user_id or m.recepient_id=:current_user_id
                GROUP BY contact_name,contact_id,contact_avatar_img,msgs_count";
        $stm = $this->db->prepare($sql);
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $stm->bindParam(':current_user_id', $current_user_id, \PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll();
    }
}
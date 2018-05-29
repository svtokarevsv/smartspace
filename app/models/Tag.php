<?php
namespace App\models;
use App\lib\App;
use App\lib\Model;

class Tag extends Model
{

    // get tags by keyword (for autocomplete)
    public static function getTagsBySearchWord($searchWord)
    {
        $sql = "SELECT keyword FROM keywords 
                WHERE keyword LIKE '%$searchWord%';";
        $stm = App::$db->prepare($sql);
        $stm->setFetchMode(\PDO::FETCH_OBJ);
        $stm->bindParam(':searchWord', $searchWord);
        $stm->execute();
        return $stm->fetchAll();
    }

    // get tags by Keyword
    public static function getTagbyKeyword($input)
    {
        $sql = "SELECT * FROM keywords 
                WHERE keyword=:input" ;
        $stm = App::$db->prepare($sql);
        $stm->setFetchMode(\PDO::FETCH_OBJ);
        $stm->bindParam(':input', $input);
        $stm->execute();
        return $stm->fetch();
    }

    // add new tag to table keywords
    public static function addNewTag($newTag)
    {
        $sql = "INSERT INTO keywords (keyword)
                VALUES(:newTag)" ;
        $stm = App::$db->prepare($sql);
        $stm->bindParam(':newTag', $newTag);
        return $stm->execute();
    }

    // add tags to keywords_in_students table
    public static function addTagsToStudent($sid, $tag)
    {
        $sql = "INSERT INTO keywords_in_students (user_id, keyword_id)
                VALUES(:sid, :newTag)" ;
        $stm = App::$db->prepare($sql);
        $stm->bindParam(':sid', $sid);
        $stm->bindParam(':newTag', $tag);
        return $stm->execute();
    }
    // delete tags in keywords_in_students table
    public static function deleteCurrentTags($sid)
    {
        $sql = "DELETE FROM keywords_in_students
                WHERE user_id=:sid;" ;
        $stm = App::$db->prepare($sql);
        $stm->bindParam(':sid', $sid);
        return $stm->execute();
    }
    //read tags
    public static function getTagsOfStudent($sid)
    {
        $sql = "SELECT * FROM keywords
                JOIN keywords_in_students ON keywords.id=keywords_in_students.keyword_id  
                WHERE user_id=:sid;" ;
        $stm = App::$db->prepare($sql);
        $stm->setFetchMode(\PDO::FETCH_ASSOC);
        $stm->bindParam(':sid', $sid);
        $stm->execute();
        return $stm->fetchAll();
    }
}


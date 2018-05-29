<?php

namespace App\controllers;

use App\lib\Controller;
use App\models\Tag;

class TagController extends Controller
{
    public function __construct(array $data = array())
    {
        parent::__construct($data);
    }

    public function ajax_getTagsByUserInput(){
        // 3. $_GET[] is comming from js {couuntryId}
        $searchWord = $_GET['searchWord']; 

        // 4. use this $countryId to execute the sql statement
        // $this->data['cities'] is a cities from db
        $this->data['tags'] = Tag::getTagsBySearchWord($searchWord);

    }
}



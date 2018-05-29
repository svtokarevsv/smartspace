<?php

namespace App\controllers;

use App\lib\Controller;
use App\models\Geo;

class GeoController extends Controller
{
    public function __construct(array $data = array())
    {
        parent::__construct($data);
    }

    public function ajax_getCitiesByCountryId(){
        // 3. $_GET[] is comming from js {couuntryId}
        $countryId = $_GET['countryId']; 

        // 4. use this $countryId to execute the sql statement
        // $this->data['cities'] is a cities from db
        $this->data['cities'] = Geo::getCitiesByCountryId($countryId);
    }
}



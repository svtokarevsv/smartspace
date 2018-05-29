<?php


namespace App\controllers;


use App\lib\Controller;

class ExternalController extends Controller
{

    public function ajax_get_random_fact_by_year()
    {
        $this->data=file_get_contents('http://numbersapi.com/random/year');
    }
    public function ajax_get_random_fact_by_date()
    {
        $this->data=file_get_contents('http://numbersapi.com/random/date');
    }
}
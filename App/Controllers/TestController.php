<?php

namespace App\Controllers;

class TestController {
    public function __construct(){
        echo "This class has been automatically loaded <br>";
    }

    public function index(){
        echo "This is the index method, which is automatically executed";
    }

    public function functionWithParam(string $param){
        echo "The given Param is: " . $param;
    }
}
<?php

namespace App;

class Router {

    private $requestedController;
    private $requestedMethod;
    private $requestedParams;

    public function __construct()
    {
        $this->parseURL($_SERVER['REQUEST_URI']);
    }
    
    private function parseURL(string $url){
        $url = rtrim($url,"/");
        $urlParts = explode("/", $url);
        
        if(!is_null($urlParts[1])){
            $this->requestedController = "App\\Controllers\\".ucfirst($urlParts[1])."Controller";
        } else {
            $this->requestedController = null;
        }

        $this->requestedMethod = $urlParts[2] ?? "index";
        $this->requestedParams = $urlParts[3] ?? null;
    }

    public function getRequestedController(){
        return $this->requestedController;
    }

    public function getRequestedMethod(){
        return $this->requestedMethod;
    }

    public function getRequestedParams(){
        return $this->requestedParams;
    }

}
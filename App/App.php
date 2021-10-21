<?php

namespace App;

use App\Test;
use App\Router;

class App {

    public function __construct()
    {
        $this->autoloadClasses();
        $router = new Router();
        $requestedController = $router->getRequestedController();
        $requestedMethod = $router->getRequestedMethod();
        $requestedParams = $router->getRequestedParams();


        $controller = new $requestedController;
        
        if(is_null($requestedParams)){
            $controller->{$requestedMethod}();
        } else {
            $controller->{$requestedMethod}($requestedParams);
        }

    }

    private function autoloadClasses()
    {
        spl_autoload_register(function($className) {
            $projectNamespace = 'App\\';
            $className = str_replace($projectNamespace, '', $className);
            $file = './app/' . str_replace('\\', '/', $className) . '.php';

            if (file_exists($file)) {
                require_once $file;
            }
        });
    }

}

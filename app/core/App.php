<?php

class App{

    private $controller = 'Home';   //default controller
    private $method = 'index';      //default method

    private function splitURL(){
        
        $URL = $_GET['url'] ?? 'home';   //if there's no parameters in the URL -> direct to home
        $URL = explode("/", trim($URL, "/"));
         return $URL;
    }
    
    public function loadController(){          //load pages (controllers)
        
        $URL = $this->splitURL();

        //select controller
        $filename = "../app/controllers/".ucfirst($URL[0]).".php";
        if (file_exists($filename)){
            require $filename;
            $this->controller = ucfirst($URL[0]); 
            unset($URL[0]); 
        }
        else{
            $filename = "../app/controllers/_404.php";
            require $filename;
            $this->controller = "_404";  
        }

        $controller = new $this->controller;

        //select methods
        if(!empty($URL[1])){
            if(method_exists($controller, $URL[1])){
                $this->method = $URL[1]; 
                unset($URL[1]);
            }
        }

        call_user_func_array([$controller, $this->method], $URL);
    }
}


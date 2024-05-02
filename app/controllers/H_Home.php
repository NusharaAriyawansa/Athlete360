<?php

class H_Home extends Controller{

    public function index() {
        $_SESSION["user"]=null;
        $this->view('home/home');
    }

   

    



    


    
}


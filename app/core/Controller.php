<?php

class Controller{
    
    public function view($name, $auth_user=null,$data=null){
        $current_user=null;
        if($_SESSION["user"]!=null){
       $current_user= $_SESSION["user"];
        }
        if($current_user==$auth_user){
           if($name=="admin/edit_session"){
            foreach($data as $key => $value){
                ${$key} = $value;
            }}
        $filename = "../app/views/".$name.".view.php";
        if (file_exists($filename)){
            require $filename;
        }
        else{
            $filename = "../app/views/404.view.php";
            require $filename;
        }
    }
        else{
            $filename = "../app/views/404.view.php";
            require $filename;
        }
    }

    protected function model($model) {
        require_once '../app/models/' . $model . '.php';
        return new $model();
    }

}

/*
class Controller{

    //to load the view
    public function view($name, $data = [],$null=null,$null1=null){
        if(!empty($data)){
            extract($data);
        }

        $filename = "../app/views/".$name.".view.php";
        echo $name;
        if (file_exists($filename)){
            require $filename;
        }
        else{
            $filename = "../app/views/404.view.php";
            require $filename;
        }
    }

    protected function model($model) {
        require_once '../app/models/' . $model . '.php';
        return new $model();
    }
}*/
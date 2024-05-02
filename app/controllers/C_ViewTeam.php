<?php

class C_ViewTeam extends Controller{

    public function index() {
    
        if($_SESSION["note"]=="headcoach"){
        $this->view('headCoach/viewTeam','coach');
        }else{
            redirect('C_Dashboard');

        }
        
    }

   

    



    


    
}
<?php

class M_Sessions extends Controller{

    public function index() {
        $sessionModel = new MemberSessionViewModel();
        $data = $sessionModel->load_sessions();

        
        $data1 = $sessionModel->load_Allsessions();

        $memID=$_SESSION["user_id"];
        $data2=$sessionModel->view_private_booking($memID);


        $this->view('member/sessions','member',[$data,$data1,$data2]);
    }

public function update_selection(){
    
    $sessionModel = new MemberSessionViewModel();
    $sessionModel->deleteSelections();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST['choice'])) {
            $selectedClasses = $_POST['choice']; // Array of selected classes
           
            foreach ($selectedClasses as $class) {
                $sessionModel->updateSelection($class);
            }
            
        } else {
            echo "No classes selected. Please go back and select your preferred classes.";
        }
    } else {
        // Not a POST request
        echo "Invalid request.";
    }

    redirect('M_Sessions');
 

}



   

    



    


    
}


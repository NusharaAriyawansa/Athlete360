<?php

class P_Profile extends Controller {
    public function index() {
        $userID = $_SESSION['user_id'];

        $profile = new Profile_Paymentclark();
        $data = $profile->find($userID);
        
        $this->view('paymentClark/profile','paymentClark',$data);
    }
    
}

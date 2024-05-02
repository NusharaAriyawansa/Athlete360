<?php

class A_Profile extends Controller {
    public function index() {
        $userID = $_SESSION['user_id'];
        $profile = new Profile_Admin();
        $data = $profile->find($userID);
        
        $this->view('admin/profile', 'admin', $data);
    }
}


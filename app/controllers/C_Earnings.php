<?php

class C_Earnings extends Controller{

    public function index() {
        $user_id = $_SESSION["user_id"];
        $salary = new salary_coach();

        $data['income_list_club_session']= $salary->income_club_session($user_id);
        $data['count_income_club_session']= $salary->count_income_club_session($user_id);

        $data['private_booking_members']= $salary->income_private_booking_member($user_id);
        $data['count_private_booking_members']= $salary->count_income_private_members($user_id);
        $data['total_private_booking_members']= $salary->total_income_private_members($user_id);

        $data['private_booking_non_members']= $salary->income_private_booking_non_member($user_id);
        $data['count_private_booking_non_members']= $salary->count_income_private_non_members($user_id);
        $data['total_private_booking_non_members']= $salary->total_income_private_non_members($user_id);

        $this->view('coach/earnings', 'coach', $data);
    }

    

    
    



    


    


    
}


<?php

class C_SessionManage extends Controller{ 


    public function index() {
        $user_id = $_SESSION["user_id"];
        $sessions = new session_coach(); 

        //To display in table 
        $data['club_sessions'] = $sessions->upcoming_member_sessions($user_id);
        $data['member_private_sessions'] = $sessions->upcoming_member_private_sessions($user_id);
        $data['non_member_private_sessions'] = $sessions->upcoming_non_member_private_sessions($user_id);
        

        //To display in val-boxes
        $data['u13_count'] = $sessions->count_upcoming_u13_sessions($user_id);
        $data['u15_count'] = $sessions->count_upcoming_u15_sessions($user_id);
        $data['u17_count'] = $sessions->count_upcoming_u17_sessions($user_id);
        $data['u19_count'] = $sessions->count_upcoming_u19_sessions($user_id);

        $this->view('coach/sessions', 'coach', $data);

    





    }
    
    


    


    
}


<?php


class M_Dashboard extends Controller{
    public function view_page($data) {
        $auth_user="member";
        $this->view('member/dashboard',$auth_user,$data);

    }
    public function index(){
        $ads = new Advertisements(); 
        $data['ads'] = $ads->load_announcement_top4();
        
        $userID = $_SESSION["real_user_id"];
        $query = new Queries();
        $data['all_queries'] = $query->find_replied($userID);
    
        $this->view_page($data);
        
        
    }

    public function add(): void {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $type = $_POST['type'];
            $description = $_POST['description'];
    
            $queryModel = new Queries();
            $queryModel->addQuery($type,$description);
                redirect('M_Dashboard');
        }
    
    
    
    }
    
    

    

}








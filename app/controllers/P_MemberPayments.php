<?php

class P_MemberPayments extends Controller{
    use Model;

    public function index() {
        $member_payments = new member_payments();

        $data['all_members'] = $member_payments->find_all_members();
        $data['member_all_payments'] = $member_payments->load_all_payments();
        $data['member_all_due_payments'] = $member_payments->load_all_due_payments();
        $data['count_member_all_due_payments'] = $member_payments->count_load_all_due_payments();
        $data['sum_member_all_due_payments'] = $member_payments->sum_load_all_due_payments();
       
        $data['option'] = null;

        $this->view('paymentClark/memberPayments', 'paymentClark',$data);
    }

    public function load_payments() {
        $member_payments = new member_payments();
        $data['all_members'] = $member_payments->find_all_members();
        $data['member_all_payments'] = $member_payments->load_all_payments();
        $data['member_all_due_payments'] = $member_payments->load_all_due_payments();
        $data['count_member_all_due_payments'] = $member_payments->count_load_all_due_payments();
        $data['sum_member_all_due_payments'] = $member_payments->sum_load_all_due_payments();

        $data['option'] = null;
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {   
            $member=$_POST['selected_member'];

            
                    $data['option'] = $member_payments->member_unpaid_payments($member);
                
            
            
        }
        
       
        
        $this->view('paymentClark/memberPayments','paymentClark', $data);

    }

    public function paid(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Check which button is clicked
        if($_POST["action"]!="paid"){
          $id=$_POST["action"];
          $sql_paid = "DELETE FROM due_membership_payment WHERE due_membership_payment.id = $id";
          $this->delete($sql_paid);
        }
            
        }
        redirect("P_MemberPayments");
    }


   
    



    


    
}

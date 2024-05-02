<?php

class P_CoachPayments extends Controller{
    use Model;

    public function index() {
        $paymentsModel = new coach_payments();
        $data['all_coaches'] = $paymentsModel->findAllCoaches();
        $data['all_salaries'] = $paymentsModel->findAllSalaries();
        $data['all_due_salaries'] = $paymentsModel->findAllDueCoaches();

        $data['count_due_coaches'] = $paymentsModel->countDueCoaches();
        $data['total_due_payments'] = $paymentsModel->totalDuePayments();

        

        $data['option'] = null;
        $data['coach_total'] = 0;
        $data['coach_paid'] = 0;
        $data['coach_unpaid'] = 0;

        $data['coach_unpaid_club_session'] =$this->load_club_sessions_due();

        $this->view('paymentClark/CoachPayments','paymentClark',$data);
        
    }

    public function salary_selected_coach(): void {
        $coach_payments_model = new coach_payments();
        $data['all_coaches'] = $coach_payments_model->findAllCoaches();
        $data['option'] = null;
        $data['coach_total'] = 0;
        $data['coach_paid'] = 0;
        $data['coach_unpaid'] = 0;

        $data['all_salaries'] = $coach_payments_model->findAllSalaries();
        $data['all_due_salaries'] = $coach_payments_model->findAllDueCoaches();
        $data['count_due_coaches'] = $coach_payments_model->countDueCoaches();
        $data['total_due_payments'] = $coach_payments_model->totalDuePayments();
        
       
        $data['coach_unpaid_club_session'] =$this->load_club_sessions_due();
        
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $coach = $_POST['selected_coach'];
            
            $action_type = $_POST['action_type'];  // Retrieve the action type from the form
    
            switch ($action_type) {
                case 'paid':
                    $data['option'] = $coach_payments_model->findAllPaidRecords($coach);
                    break;
                case 'not_paid':
                    $data['option'] = $coach_payments_model->findAllNotPaidRecords($coach);
                    break;
                case 'all':
                default:
                    $data['option'] = $coach_payments_model->findAllRecords($coach);
                    break;
            }

            if (!empty($coach)) {
                $data['coach_total'] = $coach_payments_model->perCoachTotal($coach);
                $data['coach_paid'] = $coach_payments_model->perCoachPaid($coach);
                $data['coach_unpaid'] = $coach_payments_model->perCoachUnpaid($coach);
            }
        }
        $this->view('paymentClark/CoachPayments', 'paymentClark', $data);
    }

    private function load_club_sessions_due(){

        $paymentsModel = new coach_payments();
        $data['all_coaches'] = $paymentsModel->findAllCoaches();
        $data['all_salaries'] = $paymentsModel->findAllSalaries();
        $data['all_due_salaries'] = $paymentsModel->findAllDueCoaches();

        $data['count_due_coaches'] = $paymentsModel->countDueCoaches();
        $data['total_due_payments'] = $paymentsModel->totalDuePayments();

        $data['option'] = null;
        $data['coach_total'] = 0;
        $data['coach_paid'] = 0;
        $data['coach_unpaid'] = 0;

        

        $coach_payments_model = new coach_payments();
        $domestic_return =$coach_payments_model->retrive_coaches_unpaid_club_session_sum();
        return $domestic_return;

    }

    public function pay(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Check which button is clicked
       
          $id=$_POST["action"];
          $sql_paid = "DELETE FROM coach_totsl WHERE coach_id = $id";
          $this->delete($sql_paid);

          redirect("P_CoachPayments");
        }
            
        }
    
    }

    


   

    



    


    



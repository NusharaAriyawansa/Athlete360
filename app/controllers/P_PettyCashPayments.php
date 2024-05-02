<?php

class P_PettyCashPayments extends Controller{

    public function index() {

        $cash = new PettyCash();
        $data['records'] = $cash->find();
    
        $this->view('paymentClark/pettyCashPayments','paymentClark', $data);
    }

    public function add(): void {
        $data = [];
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $category = $_POST['category'];
            $description = $_POST['description'];
            $amount = $_POST['amount'];

            $cash = new PettyCash();
            $cash->addRecord($category, $description, $amount);
                redirect('P_PettyCashPayments');
        }
    }

    public function delete($payment_id): void
    {
        $ad = new PettyCash();
        $ad->deleteRecord($payment_id);

        redirect('P_PettyCashPayments'); 
    }
   
    public function update(): void {
        $data = [];
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $payment_id = $_POST['updatePayment_id'];
            $timestamp = $_POST['updateTimestamp'];
            $category = $_POST['updateCategory'];
            $description = $_POST['updateDescription'];
            $amount = $_POST['updateAmount'];

            $cash = new PettyCash();
            $cash->updateRecord($payment_id,$timestamp, $category, $description, $amount);
                redirect('P_PettyCashPayments');
        }
    }
  

    


    
}


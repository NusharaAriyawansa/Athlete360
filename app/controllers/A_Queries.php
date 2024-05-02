<?php

class A_Queries extends Controller{

    public function index() {

        $queries = new Queries(); 

        $data['queries_by_coaches'] = $queries->find_queries_by_coaches();
        $data['queries_by_members'] = $queries->find_queries_by_members();

        $data['count_coaches'] = $queries->coaches_total();
        $data['count_coaches_reviewed'] = $queries->coaches_reviewed();
        $data['count_coaches_not_reviewed'] = $queries->coaches_to_be_reviewed();

        $data['count_members'] = $queries->members_total();
        $data['count_members_reviewed'] = $queries->members_reviewed();
        $data['count_members_not_reviewed'] = $queries->members_to_be_reviewed();

        $this->view('admin/queries', 'admin', $data);        
    }

    public function delete($queryID): void
    {
        $query = new Queries();
        $query->deleteQuery($queryID);

        redirect('A_Queries'); 
    }

    public function update():void{
        $data = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $queryID=$_POST['updateId'];         //name is passed from the html form
            $reply = $_POST['updateReply'];

            $query = new Queries();
            $query->updateQuery($queryID, $reply);
            redirect('A_Queries');
        }
    }








}
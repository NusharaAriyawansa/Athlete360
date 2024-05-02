<?php

class A_ResourceManage extends Controller{

    public function index() {
       $resourceModel = new Resources();
       $data = $resourceModel->findResource();
       

        $this->view('admin/resourceManage', 'admin',$data);       
    }

    public function add(string $a = '', string $b = '', string $c = ''): void {
        $data = [];
        $name = $_POST['name'];
        $description=$_POST['description'];
        $status=$_POST['status'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $resourceModel = new Resources();

            if (TRUE) {  
                $resourceModel->addResource($name, $description, $status);
                redirect('A_ResourceManage');
            } else {
                $data['errors'] = $resourceModel->errors;
            }
        }
        $this->view('admin/advertisement', 'admin', $data);
    }

    public function delete($id): void
    {

        $tips = new Advertisements();
        $tips->deleteAd($id);

        redirect('A_Advertisement'); 
    }

    
    



   

    



    


    
}


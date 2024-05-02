<?php

class A_Advertisement extends Controller{

    // function to load the page 
    public function index() {
        $advertisementsModel = new Advertisements();
        $data['ads'] = $advertisementsModel->find();
        $data['total_ads'] = $advertisementsModel->totalAds();
        $data['weekly_ads'] = $advertisementsModel->weeklyAds();

        $this->view('admin/advertisement', 'admin', $data);        
    }

    // function to pass post parameters to the addAd function in the Advertisements model 
    public function add(): void {
        $data = [];
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = $_POST['title'];
            $description = $_POST['description'];

            $advertisementsModel = new Advertisements();
            $advertisementsModel->addAd($title,$description);
                redirect('A_Advertisement');
        }
    }

    // function to pass the advertisements $id to the deleteAd function in the Advertisements model
    public function delete($id): void
    {
        $ad = new Advertisements();
        $ad->deleteAd($id);

        redirect('A_Advertisement'); 
    }

    // function to pass updated post parameters to the updateAd function in the Advertisements model
    public function update():void{
        $data = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id=$_POST['updateId'];                          //name is passed from the html form
            $timestamp=$_POST['updateTime'];
            $title = $_POST['updateTitle'];
            $description = $_POST['updateDescription'];

            $advertisementsModel = new Advertisements();
            $advertisementsModel->updateAd($id,$timestamp, $title,$description);
            redirect('A_Advertisement');
        }
    }




    
}


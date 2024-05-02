<?php

//require_once('/Applications/XAMPP/xamppfiles/htdocs/Athlete360/app/core/Model.php');

class C_Teams extends Controller{

    use Database;

    private $teamsModel;

    public function __construct() {
        //$this->teamsModel = $this->model('Teams');
    }

    public function index() {

        if($_SESSION["note"]=="headcoach"){
        $this->view('headCoach/teams' ,'coach');
        }
        else{
            redirect('C_Dashboard');

        }
    }


    public function getAllTeams(){
        $conn = new mysqli("localhost", "root", "", "athlete360");
        $query = "SELECT * FROM teams";
        $allTeams = $conn->query($query);

        return $allTeams;
    }

    public function addTeam($teamIDa, $ageGroupa, $namea){
        $conn = new mysqli("localhost", "root", "", "athlete360");
        $query = "INSERT INTO `teams`(`teamID`, `ageGroup`, `name`) VALUES ($teamIDa , '$ageGroupa', '$namea')";
        $conn->query($query);

        return true;
    }
   

    



    


    
}
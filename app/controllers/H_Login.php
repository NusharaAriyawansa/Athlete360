  <?php
require_once('C:\xampp\htdocs\Athlete360\app\models\Users.php');
class H_Login extends Controller{
    
    public function index(){
        $_SESSION["user"]=null;
        $obj=new Users();
        
        $data = []; 

        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $obj->auth($_POST['email'],$_POST['password']);
            

        }
        $this->view('home/login', $data); 
    }

   

    



    


    
}


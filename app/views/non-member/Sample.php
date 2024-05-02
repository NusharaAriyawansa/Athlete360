<?php
require_once('C:\xampp\htdocs\Athlete360\app\core\Model.php');
//use Model_new;
      
    class Sample{
        use Model;
        
       
        public function lakruwan_insert($sql_booking, $sql_booked_nets, $sql_booked_coaches, $selected_nets, $selected_coaches){

            $sql=strval($sql_booking);
            $sql1=strval($sql_booked_nets);
            $sql2=strval($sql_booked_coaches);
            // $this->query($query);
            //return false;
            /* $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
            //$txt = "John Doe\n";
            fwrite($myfile, $sql);
            fclose($myfile);*/

            //$sqlnew="INSERT INTO advertisements (id, title, author, description) VALUES (NULL, 'jjl', 'admin', 'jjj')";
            //$sql="INSERT INTO bookings (date, name, id_number, contact_number, slot_id, net_id, coach_id) VALUES ('$date', '$namea', '$idNumber', '$contact_number', '$time_slot',1,1)";
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "athlete360";

            // Create connection
       $conn = new mysqli($servername, $username, $password, $dbname);
        //Check connection
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
            }
            
           
        
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        //$obj_model = new Model();
        /*
        $b_id=123;
        $net_id=1;
        
        
        
        $obj_model->insert("INSERT INTO booked_nets (bookingId, booked_net_id) VALUES ('$b_id', '$net_id')",$conn);*/
        
       /*$obj_model=new Model();
        $bookingId = $conn->insert_id;  // Get the ID of the last inserted booking*/
        $bookingId = $conn->insert_id;
        // // Insert booked nets information
        
        foreach ($selected_nets as $net_id) {
            echo "ggg";
            //echo $net_id;
            

            $sql_booked_nets = "INSERT INTO booked_nets (bookingId, booked_net_id) VALUES ('$bookingId', '$net_id')";
            $this->insert($sql_booked_nets,$conn);
        
        }

        // // Insert booked coaches information
        foreach ($selected_coaches as $coach_id) {
            //echo $coach_id;
            $sql_booked_coaches = "INSERT INTO booked_coaches (bookingId, booked_coach_id) VALUES ('$bookingId', '$coach_id')";
            $this->insert($sql_booked_coaches,$conn);
        }

        header("Location:http://localhost/athlete360/public/N_Invoice");


        //$stm = $conn->prepare($sqlnew);       //prepare the query 

        // $check = $stm->execute($sqlnew); 
        
        $conn->close();
            return false;
        }

    }

        // Class Sample {

        //     use Model;

        // }


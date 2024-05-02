<?php
 echo '<script>alert("updated")</script>'; 


$string = "mysql:hostname=" . DBHOST . ";dbname=" . DBNAME;
        $con = new mysqli("localhost", "root", "","athlete360"); 

    $id = $_POST['id'];
    $title = $_POST['title'];
    $des = $_POST['description'];
    
    $sql =" UPDATE advertisements SET title = '$title', description = '$des' WHERE id = '$id'";

    $results=$con->query($sql);

    ?>

   
    
    
    


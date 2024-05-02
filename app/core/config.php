<?php

if($_SERVER ['SERVER_NAME'] == 'localhost'){

    //database config 
    define('DBNAME', 'athlete360');
    define('DBHOST', 'localhost'); 
    define('DBUSER', 'root');
    define('DBPASS', '');  
    define('DBDRIVER', '');  

    define('URLROOT', 'http://localhost/athlete360/public');
}
else{

    //database config 
    define('DBNAME', 'athlete360');
    define('DBHOST', 'localhost');
    define('DBUSER', 'root');
    define('DBPASS', '');  
    define('DBDRIVER', '');

    define('URLROOT', 'http://localhost/athlete360/public');
}

define('APP_NAME', 'Athlete360');
define('APP_DESC', 'Sports Center Management System');

//true means show errors
define('DEBUG', true);


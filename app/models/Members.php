<?php

class Members{

    use Model;
    
    protected $table = 'members'; 
    protected $allowedColumns = [
        'school', 
        'grade',
    ];
    
}
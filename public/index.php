<?php
session_start();       //always start with index.php

//DEBUG ? ini_set('display_errors', 1) : ini_set('display_errors', 0);

require "../app/core/init.php";

$app = new App; 
$app->loadController();


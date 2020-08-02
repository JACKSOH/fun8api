<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'id14515751_superhost');
define('DB_PASSWORD', 'aNHWG(W7ff+zE}h[');
define('DB_NAME', 'id14515751_fun8');

$link = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);


if($link->connect_error){ // Check connection
    die("ERROR: Could not connect. " . mysqli_connect_error());
}   

?>
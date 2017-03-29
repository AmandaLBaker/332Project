<?php
/*
// connecting to database if it's on your laptop
$host = "localhost";
$db_name = "cisc332db";
$username = "cisc332";
$password = "cisc332password"; 
*/

// connecting to database on virtual machine
$host = "localhost";
$db_name = "ktcs_company";
$username = "root";
$password = "AMANDA, put the password to your machine here";

try {
    $con = new mysqli($host,$username,$password, $db_name);
}

// if connection.php displays nothing, that is a good sign because it means there were no errors

// show error
catch(Exception $exception){
    echo "Connection error: " . $exception->getMessage();
} 

?> 


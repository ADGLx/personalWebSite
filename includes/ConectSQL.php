<?php
//This things gotta be changed once I set the server up
$dbServername = "localhost";
$dbUserName = "root";
$dbPassword = "S3rverPassword"; 

$dbName= "loginsystem";

if($_SERVER['HTTP_HOST'] == "localhost")
{
    $conn = mysqli_connect($dbServername, $dbUserName,"" , $dbName);
}
 else 
 {
    $conn = mysqli_connect($dbServername, $dbUserName, $dbPassword, $dbName);
 }




//Dont need to close it since its only an php
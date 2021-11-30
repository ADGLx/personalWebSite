<?php
//This things gotta be changed once I set the server up
$dbServername = "localhost";
$dbUserName = "root";
$dbPassword = "S3rverPassword"; 

$dbName= "loginsystem";

$conn = mysqli_connect($dbServername, $dbUserName, $dbPassword, $dbName);

if(!$conn)
$conn = mysqli_connect($dbServername, $dbUserName,"" , $dbName);

//Dont need to close it since its only an php
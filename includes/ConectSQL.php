<?php
//This things gotta be changed once I set the server up
$dbServername = "localhost";
$dbUserName = "root";
$dbPassword = ""; 

$dbName= "loginsystem";

$conn = mysqli_connect($dbServername, $dbUserName, $dbPassword, $dbName);


//Dont need to close it since its only an php
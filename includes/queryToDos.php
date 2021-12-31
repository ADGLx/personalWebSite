<?php
session_start();//Not sure why but this works
require_once 'ConectSQL.php'; //Connects to the SQL

if(isset($_GET["typeOfToDo"]) !=null)
{
    $id =  $_GET["typeOfToDo"];
} else 
{
    $id = "Type not found";
}

$usr = $_SESSION["userid"];
$sql = "SELECT * FROM todos WHERE userid=$usr AND typeid=$id";
    if($r = mysqli_query($conn, $sql))
    {
      
        
        while ($row = mysqli_fetch_assoc($r))
        {
            $allOutput = $row["name"]."&?".$row["id"]."|";

            echo $allOutput;
        }

    } else {
        echo "Error could not fetch data base ";
    }
    
   

?>
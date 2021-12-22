<?php

session_start();//Not sure why but this works
require_once 'ConectSQL.php'; //Connects to the SQL
if(isset($_GET["editID"]) !=null)
{
    $id =  $_GET["editID"];
} else 
{
    $id = "Id not found";
}
   
    $sql = "SELECT * FROM `reminders` WHERE id =$id";
    if($result = mysqli_query($conn, $sql))
    {
        
        $row = $result -> fetch_assoc();

           //Delete the thingy and display the page again
           if($row["userid"] == $_SESSION["userid"])
           {
             $allOutput = 
             $row["title"] . "\n" . //0
             $row["time"] . "\n" .
             $row["date"] ."\n" . 
             $row["priority"] . "\n" .
             $row["notify"] . "\n" .
             $row["description"] . "\n" .
             $row["id"];
              echo $allOutput;
           }
          


    } else {
        echo "Error could not fetch data base ";
    }
   // header("location: ../index.php?message=".$id);
   

?>
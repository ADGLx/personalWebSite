<?php
    if(isset($_POST["delete"]))
    {
      session_start();//Not sure why but this works
      include_once "ConectSQL.php"; //This fixes the connection issue
       //In here I can delete the entry from the server
         $idToBeDeleted = $_POST["delete"];

         $sql = "SELECT * FROM reminders WHERE id =$idToBeDeleted";
         //Before deleting just make sure the id of the thing that is going to be deleted
         //belongs to the user
         if($result = mysqli_query($conn, $sql))
         {
            $row = $result -> fetch_assoc();

            if($row["userid"] == $_SESSION["userid"])
            {
               //Delete the thingy and display the page again
               $sql = "DELETE FROM reminders WHERE id=$idToBeDeleted";
               
               if($result = mysqli_query($conn, $sql))
               header("location: ../index.php?message=reminderDeleted");
            }
            
            //if(mysqli_fetch_assoc($result)[0]=== )
         }
         
    //   $sql = "DELETE FROM reminders WHERE id=$idToBeDeleted";

      // header("location: ../index.php?".$_SESSION["userid"]); //Refreshes the page
       
    } 
    else if(isset($_POST["edit"]))
    {
      session_start();//Not sure why but this works
      include_once "ConectSQL.php"; //This fixes the connection issue
         $idToBeEdited = $_POST["edit"];

         //EDIT THE THING IN THE DATA BASE HERE

    }
    else {
      header("location: ../index.php?errors");
    }
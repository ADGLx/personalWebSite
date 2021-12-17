<?php
 
   
    if(isset($_POST["submit"]))
    {
        //Send also the user ID so we know who created the reminder
        session_start(); //Had to start a session here to check the ID
       $rmduserID = $_SESSION["userid"];
       $rmdTitle = $_POST['rmdTitle'];
       $rmdTime = $_POST['rmdTime'];
       $rmdDate = $_POST['rmdDate'];
       $rmdPriority = $_POST['rmdPriority'];
       $rmdNotify = $_POST['rmdNotify'];
       $rmdDescription = $_POST['rmdDescription'];
       $rmdColor = $_POST['rmdColor'];

       $rmdID = $_POST['submit'];

      


        require_once 'ConectSQL.php'; //Connects to the SQL

        if(empty($rmduserID))
        {
            header("location: ../LoginPage.php?error=LoggedOut");
            exit();
        }
        else if(empty($rmdTitle))
        {
            header("location: ../index.php?error=emptyTitle");
            exit();
        } 
        else if(empty($rmdTime))
        {
            header("location: ../index.php?error=emptyTime");
            exit();
        } 
        else if(empty($rmdDate))
        {
            header("location: ../index.php?error=emptyDate");
            exit();
        } 

       // loginUser ($conn, $usn, $pwd);
       editReminderInDatabase($conn, $rmduserID,$rmdTitle, $rmdTime, $rmdDate, $rmdPriority, $rmdNotify, $rmdDescription, $rmdColor, $rmdID);
       //header("location: ../index.php?error=$rmdID");

    } else 
    {
        header("location: ../index.php?error=idkData");
        exit();
    }

    


    function editReminderInDatabase($conn,$userid ,$title, $time, $date, $priority, $notify, $description, $color, $idToEdit)
    {
        $newNotify =0;
        if($notify == "")
        {
            $newNotify =0;
        } else 
        {
            $newNotify = 1;
        }


        $sql = "UPDATE reminders SET userid='$userid',title='$title',time='$time',date='$date',priority='$priority',notify='$newNotify',description='$description',color='$color' WHERE id=$idToEdit AND userid=$userid";

        // save to db and check
			if(mysqli_query($conn, $sql)){
				// success
                header("location: ../index.php"); //Refreshes the page
			} else {
				echo 'query error: '. mysqli_error($conn);
			}
    }
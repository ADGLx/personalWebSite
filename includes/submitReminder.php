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
     //  $rmdColor = $_POST['rmdColor'];

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
      // storeReminderInDatabase($conn, $rmduserID,$rmdTitle, $rmdTime, $rmdDate, $rmdPriority, $rmdNotify, $rmdDescription, $rmdColor);
      storeReminderInDatabase($conn, $rmduserID,$rmdTitle, $rmdTime, $rmdDate, $rmdPriority, $rmdNotify, $rmdDescription);

    } else 
    {
        header("location: ../index.php?error=idkData");
        exit();
    }

    


    function storeReminderInDatabase($conn,$userid ,$title, $time, $date, $priority, $notify, $description)
    {
        $newNotify =0;
        if($notify == "")
        {
            $newNotify =0;
        } else 
        {
            $newNotify = 1;
        }


        $sql = "INSERT INTO reminders(userid,title,time,date,priority,notify,description) VALUES('$userid','$title','$time','$date','$priority','$newNotify','$description')";

        // save to db and check
			if(mysqli_query($conn, $sql)){
				// success
                header("location: ../index.php?weeknmb=".$_SESSION["curWeek"]); //Refreshes the page
			} else {
				echo 'query error: '. mysqli_error($conn);
			}
    }
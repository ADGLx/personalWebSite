<?php
    if(isset($_POST["submit"]))
    {
        session_start(); //This allows me to check for ID for some reason

        $usrID = $_SESSION["userid"];
        $todoName = $_POST["name"];
        $todoC = $_POST["color"];

        if(empty($usrID))
        {
            header("location: ../LoginPage.php?error=LoggedOut");
        exit();
        } else if(empty($todoName))
        {
            header("location: ../index.php?error=emptyfield");
            exit();
        }

        storeTodoType($usrID, $todoName, $todoC);
        
    }


    function storeTodoType($uID, $tName, $color)
    {
        require_once 'ConectSQL.php'; //Connects to the SQL

        $sql = "INSERT INTO todos_type(userid, name, color) VALUES ('$uID', '$tName', '$color')";

        if(mysqli_query($conn, $sql)){
            //Change this so it doesnt refresh
            header("location: ../index.php?weeknmb=".$_SESSION["curWeek"]); //Refreshes the page
        } else {
            echo 'query error: '. mysqli_error($conn);
        }
    }
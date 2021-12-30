<?php
    if(isset($_GET["name"]))
    {
        session_start(); //This allows me to check for ID for some reason

        $usrID = $_SESSION["userid"];
        $todoName = $_GET["name"];
        $todoType = $_GET["type"];

        if(empty($usrID))
        {
            header("location: ../LoginPage.php?error=LoggedOut");
        exit();
        } else if(empty($todoName))
        {
            header("location: ../index.php?error=emptyfield");
            exit();
        }

        storeTodo($usrID, $todoName, $todoType);
        
    }


    function storeTodo($uID, $tName, $tType)
    {
        require_once 'ConectSQL.php'; //Connects to the SQL

        $sql = "INSERT INTO todos(userid, name, typeid) VALUES ('$uID', '$tName', '$tType')";

        if(mysqli_query($conn, $sql)){
            //Change this so it doesnt refresh
            //header("location: ../index.php?weeknmb=".$_SESSION["curWeek"]); //Refreshes the page
        } else {
            echo 'query error: '. mysqli_error($conn);
        }

        mysqli_close($conn); //Cloe it here because it will be grabbed by an HTTP request
    }
    
    ?>
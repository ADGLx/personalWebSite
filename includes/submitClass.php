<?php

if(isset($_POST["submit"]))
{
    session_start(); //This allows me to check for ID for some reason

    $usrID = $_SESSION["userid"];
    $className = $_POST["name"];
    $classType = $_POST["type"];
    $classLocation = $_POST["location"];
    $classDescription = $_POST["description"];
    $classColor = $_POST["color"];

    //The times, might wanna store them in a array or sum
    $startTimes = array($_POST["timeS1"], $_POST["timeS2"], $_POST["timeS3"], $_POST["timeS4"], $_POST["timeS5"],$_POST["timeS6"]);
    $endTimes = array($_POST["timeE1"], $_POST["timeE2"], $_POST["timeE3"], $_POST["timeE4"], $_POST["timeE5"],$_POST["timeE6"]);
    $dayTimes = array($_POST["timeD1"], $_POST["timeD2"], $_POST["timeD3"], $_POST["timeD4"], $_POST["timeD5"],$_POST["timeD6"]);

   

    if(empty($usrID))
    {
        header("location: ../LoginPage.php?error=LoggedOut");
        exit(); 
    }
    else if(empty($className) || empty($classType) || empty($classLocation))
    {
        header("location: ../index.php?error=emptyfield");
        exit();
    }

    storeClassInDataBase($usrID, $className, $classType, $classLocation, $classDescription, $classColor, $startTimes, $endTimes, $dayTimes);

} else 
{
    header("location: ../index.php?error=errorSubmittingClass");
    exit();
}


function storeClassInDataBase($uID, $cName, $cType, $cLocation, $cDescription, $cColor, $sTimes, $eTimes, $dTimes)
{
    require_once 'ConectSQL.php'; //Connects to the SQL
    
    $sql = "INSERT INTO classes(userid, name, type, location, description, color, 
    timeS1, timeE1, timeD1,
    timeS2, timeE2, timeD2,
    timeS3, timeE3, timeD3,
    timeS4, timeE4, timeD4,
    timeS5, timeE5, timeD5,
    timeS6, timeE6, timeD6) 
    VALUES('$uID','$cName','$cType','$cLocation','$cDescription','$cColor'
    ,'$sTimes[0]','$eTimes[0]','$dTimes[0]'
    ,'$sTimes[1]','$eTimes[1]','$dTimes[1]'
    ,'$sTimes[2]','$eTimes[2]','$dTimes[2]'
    ,'$sTimes[3]','$eTimes[3]','$dTimes[3]'
    ,'$sTimes[4]','$eTimes[4]','$dTimes[4]'
    ,'$sTimes[5]','$eTimes[5]','$dTimes[5]' )";

    if(mysqli_query($conn, $sql)){
        // success
        header("location: ../index.php?weeknmb=".$_SESSION["curWeek"]); //Refreshes the page
    } else {
        echo 'query error: '. mysqli_error($conn);
    }
}
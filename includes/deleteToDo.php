<?php
    session_start();//Not sure why but this works
    require_once 'ConectSQL.php'; //Connects to the SQL

    if(isset($_GET["id"]) !=null)
    {
        $id = $_GET["id"];
    } 
    else 
    {
        $id = "Type not found";
    }

    $usr = $_SESSION["userid"];
    $sql = "DELETE FROM todos WHERE userid=$usr AND id=$id";

    if($result = mysqli_query($conn, $sql))
    {
        echo"a";
    }

?>
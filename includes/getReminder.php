<?php
    
    $tempUser = $_SESSION["userid"];

    $sql = "SELECT * FROM reminders WHERE userid =$tempUser";

    if($result = mysqli_query($conn, $sql))
    {
        //Grabs the result in an array and print them all 
    while ($row = mysqli_fetch_assoc($result)) 
    {
        addRowToReminderTable($row["title"],$row["date"],$row["time"], $row["description"]);
        }
    } else{
        echo "Error at getting database";
    }
    
    mysqli_free_result($result);

    function addRowToReminderTable($title, $date, $time, $description)
    {
        echo " 
            <tr>
                <td>$title</td> <td> $date</td><td>$time</td><td>$description</td>
            </tr>";
    }
<?php
    //This is supposed to get and print the currents week reminders in the schedule
    $tempUser = $_SESSION["userid"];

    //This for now only does this week
    $sql = "SELECT * FROM `reminders` WHERE 
            date >= CURRENT_DATE() - INTERVAL DAYOFWEEK(CURRENT_DATE()) - 2 DAY
            AND date <= CURRENT_DATE() - INTERVAL DAYOFWEEK(CURRENT_DATE()) - 8 DAY";

    if($result = mysqli_query($conn, $sql))
    {
        //Grabs the result in an array and print them all 
    while ($row = mysqli_fetch_assoc($result)) 
    {
       // addRowToReminderTable($row["title"],$row["date"],$row["time"], $row["description"], $row["id"]);
        
    }

    
    } else{
       PrintFullEmptyTable();
    }
    
    mysqli_free_result($result);


    function PrintFullEmptyTable()
    {
        
        echo "
        <tr class='tableRowFormat'>
        <td>
        <button class='btn btn-success' type='button' style='width:100%; background-color:;'>Place Holder (9:00am)</button>
        </td>
        <td></td>
        <td> <button class='btn btn-success' type='button' style='width:100%; background-color:;'>Create dynamic calendar (10:10am)</button> </td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <th >Morning <br>(7am-12pm)</th>
      </tr>
      <tr class='tableRowFormat'>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <th>Afternoon <br>(12pm-4pm)</th>
      </tr>
      <tr class='tableRowFormat'>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <th>Evening<br>(4pm-8pm)</th>
      </tr>
      <tr class='tableRowFormat'>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <th>Night<br>(8pm-12am)</th>
      </tr>
        ";
    }

    function PrintTableWithData($data)
    {
        //Gotta match the data with the day and stuff
        //Has to print 4 rows and 5 columns
       
    }

   
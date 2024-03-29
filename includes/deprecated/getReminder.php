<?php
    
    //Check for mobile device
   if(isset($_COOKIE['scrnSize']) && $_COOKIE['scrnSize']=='small' )
   {
    $isMobile = true;
   } else{
    $isMobile = false; 
   }


    $tempUser = $_SESSION["userid"];

    $weekNumber =0;
    if(isset($_GET["weeknmb"]) !=null)
    {
      $weekNumber = $_GET["weeknmb"];
    }
    
    $weekNumber = $weekNumber*7;


    if($isMobile)
    {
        echo" <thead>
        <tr>
          <th>This Week's Reminders</th>
          <th>Date</th>
          <th>Options </th>
        </tr>
      </thead>
      ";

    } else{
    //Prin all the stuff for the table
    echo" <thead>
    <tr>
      <th>This Week's Reminders</th>
      <th>Date</th>
      <th>Time</th>
      <th>Description</th>
      <th>Options </th>
    </tr>
  </thead>
  ";
    }






    $sql = "SELECT * FROM `reminders` WHERE 
            userid =$tempUser AND
            date >= CURRENT_DATE() - INTERVAL DAYOFWEEK(CURRENT_DATE()) - (1 + $weekNumber) DAY
            AND date <= CURRENT_DATE() - INTERVAL DAYOFWEEK(CURRENT_DATE()) - (7 + $weekNumber) DAY";

    if($result = mysqli_query($conn, $sql))
    {
        //Grabs the result in an array and print them all 
    while ($row = mysqli_fetch_assoc($result)) 
    {
        if($isMobile)
        addRowToReminderTableSmall($row["title"],$row["date"],$row["time"], $row["description"], $row["id"]);
        else
        addRowToReminderTable($row["title"],$row["date"],$row["time"], $row["description"], $row["id"]);
    }


    if(mysqli_num_rows($result) == 0)
    {
        echo "<tr> 
        <td colspan=5 style='text-align:center'>You are free!</td>
         </tr>";
    }


    } else{
        echo "Error at getting database";
    }
    
    mysqli_free_result($result);

    //This basically adds the HTML to the page
    function addRowToReminderTable($title, $date, $time, $description, $id)
    {
        echo " 
            <tr>
                <td>$title</td> <td> $date</td><td>$time</td><td>$description</td>
                <td>
                <form action='includes/deleteReminder.php' method='POST'>
                <button type='button' onclick='showReminderInfoModal($id)' class='btn btn-success btn-sm' data-bs-toggle='modal' data-bs-target='#ReminderEditModel' name='edit' id='$id' value='$id'  ' >Edit</button>
                <button type='button delete' class='btn btn-danger btn-sm' name='delete' value='$id'>Delete</button>
                  </form>
                </td>
            </tr>";
    }

    //This is for mobile
    function addRowToReminderTableSmall($title, $date, $time, $description, $id)
    {
        echo " 
        <tr>
            <td>$title</td> <td> $date</td>
            <td>
            <form action='includes/deleteReminder.php' method='POST'>
            <button type='button' onclick='showReminderInfoModal($id)' class='btn btn-success btn-sm' data-bs-toggle='modal' data-bs-target='#ReminderEditModel' name='edit' id='$id' value='$id'  ' >Edit</button>
            <button type='button delete' class='btn btn-danger btn-sm' name='delete' value='$id'>Delete</button>
              </form>
            </td>
        </tr>";
    }
<?php
session_start();
$tempUser = $_SESSION["userid"];

$weekNumber =0;
if(isset($_GET["week"]) !=null)
{
  $weekNumber = $_GET["week"];
}



$isMobile = false;

if(isset($_GET['mobile']) && $_GET['mobile']==1)
{
    $isMobile = true;
}

if(!$isMobile)
{
  $weekNumber = $weekNumber*7;
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
$sql = "SELECT * FROM `reminders` WHERE 
            userid =$tempUser AND
            date >= CURRENT_DATE() - INTERVAL DAYOFWEEK(CURRENT_DATE()) - (1 + $weekNumber) DAY
            AND date <= CURRENT_DATE() - INTERVAL DAYOFWEEK(CURRENT_DATE()) - (7 + $weekNumber) DAY";

} else 
{
  echo" <thead>
  <tr>
    <th>This Week's Reminders</th>
    <th>Options </th>
  </tr>
</thead>
";
 //This is really just the day number
    if($weekNumber >=0)
    {
      $curDate = date('Y-m-d', strtotime(' + '.$weekNumber.' days'));
      $year = date('Y', strtotime(' + '.$weekNumber.' days'));
    }

    else
    {
      $weekNumber = abs($weekNumber);
      $curDate = date('Y-m-d', strtotime(' - '.$weekNumber.' days'));
      $year = date('Y', strtotime(' - '.$weekNumber.' days'));
    }
   // echo date('W', strtotime($curDate));
    $weekNumber = strftime("%U", strtotime($curDate ) ); //Now it is actually the week number

    //This is really slow but whatever
    $sql = "SELECT * FROM `reminders` WHERE 
            userid =$tempUser AND
            WEEK(date) = $weekNumber";
}

  require_once 'ConectSQL.php'; //Connects to the SQL


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
                <button type='button' onclick='showReminderInfoModal($id)' class='btn btn-success btn-sm' data-bs-toggle='modal' data-bs-target='#ReminderEditModel' name='edit' id='$id' value='$id'  ' >View</button>
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
            <td>$title</td>
            <td>
            <form action='includes/deleteReminder.php' method='POST'>
            <button type='button' onclick='showReminderInfoModal($id)' class='btn btn-success btn-sm' data-bs-toggle='modal' data-bs-target='#ReminderEditModel' name='edit' id='$id' value='$id'  ' >View</button>
            <button type='button delete' class='btn btn-danger btn-sm' name='delete' value='$id'>Delete</button>
              </form>
            </td>
        </tr>";
    }
  
?>
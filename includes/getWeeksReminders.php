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
    if ($row = mysqli_fetch_assoc($result)) 
    {
       // addRowToReminderTable($row["title"],$row["date"],$row["time"], $row["description"], $row["id"]);
        PrintTableWithData($result);
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
      $targetYear = date("Y"); //Gets this year
      $date = new DateTime(date("y")."-".date("m")."-".date("d")); //Gets todays date

      //These are things
      $weekN = $date->format("W"); //week number

      if($weekN <10)
      $weekN = "0".$weekN; //Adds the 0 for strtotime

      //This gets the monday of that week
      $mondayDate = strtotime(date("Y")."W".$weekN); //This just gets the date
      //$mondayDate = date('d.m.y',strtotime(date("Y")."W".$weekN));

      $entireWeekData = array();
      for($i = 0; $i < 7; $i++)
      {
        date("d.m.y",array_push($entireWeekData,mktime(0, 0, 0, date("m", $mondayDate)  , date("d",$mondayDate)+1, date("Y",$mondayDate))));
      }
      
      //$tomorrow  = mktime(0, 0, 0, date("m", $mondayDate)  , date("d",$mondayDate)+1, date("Y",$mondayDate));
      $test = $entireWeekData[0];
      //Print table header too:
      echo "
      <p>$test</p>
      <tr>
                    <th class='day' id='d0'>Monday <br> $mondayDate </th>
                    <th class='day' id='d1'>Tuesday <br> 16-11-2021</th>
                    <th class='day' id='d2'>Wednesday <br> 17-11-2021</th>
                    <th class='day' id='d3'>Thursday <br> 18-11-2021</th>
                    <th class='day' id='d4'>Friday <br> 19-11-2021</th>
                    <th class='day' id='d5'>Saturday <br> 20-11-2021</th>
                    <th class='day' id='d6'>Sunday <br> 21-11-2021</th>
                    <td class='time'>...</td>
                  </tr>
      ";
        //Gotta match the data with the day and stuff
        //Has to print 4 rows and 5 columns
       //First check the morning reminders
       $morning = array();
       $afternoon = array();
       $evening = array();
       $night = array();

       foreach($data as $value)
       {
         //If it is in the morning I have to 
         if($value["time"] < 12)
         {
           array_push($morning, $value);
         } else if($value["time"] < 16)
         {
          array_push($afternoon, $value);
         } else if($value["time"] < 20)
         {
          array_push($evening, $value);
         } else {
          array_push($night, $value);
         }
       }

       //Create array of arrays for the week
       $weekReminders = array ($morning, $afternoon, $evening, $night);

       //Start building the table here

       $rmd = "";
       $end = "";
       for($x=0;$x<4;$x++)
       {
        //do all che checks here
                //Add here the last row
                if($x==0)
                {
                  //if($week[0]["date"])

                  $end=" <th>Morning <br>(7am-12pm)</th>";
                } 
                else if($x==1)
                {
                  $end= " <th>Afternoon <br>(12pm-4pm)</th>";
                }  
                else if($x==2)
                {
                  $end= "<th>Evening<br>(4pm-8pm)</th>";
                }
                else 
                {
                  $end= "<th>Night<br>(8pm-12am)</th>";
                }


        echo "<tr class='tableRowFormat'>";
        for($y=0;$y<7;$y++)
        {
          echo "<td>".$rmd."</td>";
        }

        echo $end;

        echo "</tr>";

       }
    }

   
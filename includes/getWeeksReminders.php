<?php
    //This is supposed to get and print the currents week reminders in the schedule
    $tempUser = $_SESSION["userid"];

    $weekNumber =0;
    if(isset($_GET["weeknmb"]) !=null)
    {
      $weekNumber = $_GET["weeknmb"];
    }
    
    $weekNumber = $weekNumber*7;
    //if($weekNumber != 0)
    //echo $weekNumber;


    //This for now only does this week
    $sql = "SELECT * FROM `reminders` WHERE 
            userid =$tempUser AND
            date >= CURRENT_DATE() - INTERVAL DAYOFWEEK(CURRENT_DATE()) - (1 + $weekNumber) DAY
            AND date <= CURRENT_DATE() - INTERVAL DAYOFWEEK(CURRENT_DATE()) - (7 + $weekNumber) DAY";

    if($result = mysqli_query($conn, $sql))
    {
        //Grabs the result in an array and print them all 
    if ($row = mysqli_fetch_assoc($result)) 
    {
      if(empty($row))
      echo "erroaar";
       // addRowToReminderTable($row["title"],$row["date"],$row["time"], $row["description"], $row["id"]);
        PrintTableWithData($result, $weekNumber);
    }
    else{
      PrintTableWithData(null, $weekNumber);
    }
    } else{
       echo "error";
    }
    mysqli_free_result($result);


    function PrintFullEmptyTable($todayData)
    {
      //<button class='btn btn-success' type='button' style='width:100%; background-color:;'>Place Holder (9:00am)</button>
        
        echo "
        <tr class='tableRowFormat'>
        <td $todayData[0]></td>
        <td $todayData[1]></td>
        <td $todayData[2]></td>
        <td $todayData[3]></td>
        <td $todayData[4]></td>
        <td $todayData[5]></td>
        <td $todayData[6]></td>
        <th >Morning <br>(7am-12pm)</th>
      </tr>
      <tr class='tableRowFormat'>
      <td $todayData[0]></td>
        <td $todayData[1]></td>
        <td $todayData[2]></td>
        <td $todayData[3]></td>
        <td $todayData[4]></td>
        <td $todayData[5]></td>
        <td $todayData[6]></td>
        <th>Afternoon <br>(12pm-4pm)</th>
      </tr>
      <tr class='tableRowFormat'>
      <td $todayData[0]></td>
      <td $todayData[1]></td>
      <td $todayData[2]></td>
      <td $todayData[3]></td>
      <td $todayData[4]></td>
      <td $todayData[5]></td>
      <td $todayData[6]></td>
        <th>Evening<br>(4pm-8pm)</th>
      </tr>
      <tr class='tableRowFormat'>
      <td $todayData[0]></td>
      <td $todayData[1]></td>
      <td $todayData[2]></td>
      <td $todayData[3]></td>
      <td $todayData[4]></td>
      <td $todayData[5]></td>
      <td $todayData[6]></td>
        <th>Night<br>(8pm-12am)</th>
      </tr>
        ";
    }

    function PrintTableWithData($data , $weekNumber)
    {
      $targetDate = date('w') - ($weekNumber);//Getting the current week for now might need to add 7 or remove

      $sundayDate =  strtotime('-'.$targetDate.' days'); //This just gets the date
 
      $entireWeekData = array();
      $entireWeekDataForComp = array();
      $ifCurrentDay = array ();
      for($i = 0; $i < 7; $i++)
      {
        array_push($entireWeekData, date("d-m-y",mktime(0, 0, 0, date("m",  $sundayDate)  , date("d", $sundayDate)+$i, date("Y", $sundayDate))));
        array_push($entireWeekDataForComp, date("Y-m-d",mktime(0, 0, 0, date("m",  $sundayDate)  , date("d", $sundayDate)+$i, date("Y", $sundayDate))));
        if($entireWeekData[$i] == date("d-m-y"))
        {
          array_push($ifCurrentDay, "style=background-color:black;");
        } else 
        {
          array_push($ifCurrentDay, "");
        }
      }
      
      //Print table header too:
      echo "
      <tr>
                    <th class='day' $ifCurrentDay[0] id='d0'>Sunday <br> $entireWeekData[0] </th>
                    <th class='day' $ifCurrentDay[1] id='d1'>Monday <br> $entireWeekData[1]</th>
                    <th class='day' $ifCurrentDay[2] id='d2'>Tuesday <br> $entireWeekData[2]</th>
                    <th class='day' $ifCurrentDay[3] id='d3'>Wednesday <br> $entireWeekData[3]</th>
                    <th class='day' $ifCurrentDay[4] id='d4'>Thursday <br> $entireWeekData[4]</th>
                    <th class='day' $ifCurrentDay[5] id='d5'>Friday <br> $entireWeekData[5]</th>
                    <th class='day' $ifCurrentDay[6] id='d6'>Saturday <br> $entireWeekData[6]</th>
                    <td class='time'>...</td>
                  </tr>
      ";

      if(empty($data) || $data==null) //it is empty just show the other thing
      {
        PrintFullEmptyTable( $ifCurrentDay); //Idk if this is the right way tho, test later
      } else //If it isnt update
      {

      

       //Create array of arrays for the week with seven days and then the reminders for each
       $allReminders = array(
        //Monday (0)   (1)     (2)     (3)
        array(array(),array(),array(),array()),
        //Tuesday 
        array(array(),array(),array(),array()), 
        //Wednesday 
        array(array(),array(),array(),array()),
        //Thursday 
        array(array(),array(),array(),array()),
        //Friday 
        array(array(),array(),array(),array()),
        //Saturday 
        array(array(),array(),array(),array()),
        //Sunday
        array(array(),array(),array(),array())
       );

       //Loop throught the week and add all reminders to its specific day
      foreach($data as $value)
      {
       // $allReminders[getDayOfTheWeek($value, $entireWeekData)][getTimeSlot($value)] = $value;
        //I will use array push
        for($x=0;$x<7;$x++)
        {
          if($value["date"] == $entireWeekDataForComp[$x])
          array_push($allReminders[$x][getTimeSlot($value)], $value);
        }
        

        //array_push($allReminders[6][3], $value);
      
      }

  

       //Start building the table here

       $rmds;
       $end = "";
       for($x=0;$x<4;$x++)
       {
        //do all che checks here
                //Add here the last row
                if($x==0)
                {
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

          echo"<td $ifCurrentDay[$y]>";

          foreach($allReminders[$y][$x] as $val)
           {
             //This appearts to work just fine, which is kinda weird but whatever
               $timeTemp = date("h:ia",strtotime($val["time"]));
               
               $temp = "<button class='btn btn-success' type='button' style='width:100%; background-color:".$val["color"] .";'>".$val["title"] ."<br>(".$timeTemp.")</button>";
               echo $temp;
           }
          
          echo "</td>";
        }

        echo $end;

        echo "</tr>";

       }
       
      }
    }

    //This gets the day of the week of the reminder
    function getDayOfTheWeek ($value, $thisWeekData)
    {
      for($x =0; $x<7; $x++)
      {
        if($thisWeekData[$x] == $value["date"])
        {
          return $x;
        }
          
      }

      return null;
    }

    //This gets the time slot of the reminder
    function getTimeSlot($value)
    {
       //If it is in the morning I have to 
       if($value["time"] < 12)
       {
         return 0; //Morning
       } else if($value["time"] < 16)
       {
        return 1; //Afternoon
       } else if($value["time"] < 20)
       {
        return 2; //Evening
       } else {
        return 3; //Night
       }
    }

   
<?php
    session_start();//Not sure why but this works
    $tempUser = $_SESSION["userid"];

    require_once 'ConectSQL.php'; //Connects to the SQL

    if(isset($_GET['mobile']) && $_GET['mobile']==1)
    {
      //Get todays date and send it so I can 
      //This is week number I know but it doesnt matter the day is the same
      $weekNumber =0;
      if(isset($_GET["week"]) !=null)
      {
        $weekNumber = $_GET["week"];
      }

      if($weekNumber >=0)
      {
        $curDate = date('d-m-y', strtotime(' + '.$weekNumber.' days'));
        $compDate =date('Y-m-d', strtotime(' + '.$weekNumber.' days'));
        $td = date('w', strtotime(' + '.$weekNumber.' days')) +1;
      }
      
      else
      {
        $weekNumber = abs($weekNumber);
        $curDate = date('d-m-y', strtotime(' - '.$weekNumber.' days'));
        $compDate =date('Y-m-d', strtotime(' - '.$weekNumber.' days'));
        $td = date('w', strtotime(' - '.$weekNumber.' days')) +1;
      }
      

      
     
      $sqlC = "SELECT * FROM classes WHERE userid = $tempUser AND
      (timeD1=$td OR timeD2=$td OR timeD3=$td OR timeD4=$td OR timeD5=$td OR timeD6=$td)"; //Get all classes today

      $sql ="SELECT * FROM reminders WHERE userid =$tempUser AND date = '$compDate'";


      if($classResult = mysqli_query($conn, $sqlC))
          $allClasses = mysqli_fetch_assoc($classResult);
          else 
          {
          $allClasses = null;
          echo "Error getting classes";
          }

      if($result = mysqli_query($conn, $sql))
      {
          //Grabs the result in an array and print them all 
      if ($row = mysqli_fetch_assoc($result)) 
      {
        if(empty($row))
        echo "erroaar";

        
        PrintDayTable($result, $classResult, $curDate, $td);
      }
      else{
        PrintDayTable(null,$classResult, $curDate, $td);
      }
      } else{
        echo "error";
      }
      mysqli_free_result($result);

    } 
    else 
    {

      $weekNumber =0;
      if(isset($_GET["week"]) !=null)
      {
        $weekNumber = $_GET["week"];
      }
      
      $weekNumber = $weekNumber*7;

      $sqlC = "SELECT * FROM classes WHERE userid = $tempUser"; //Gets all classes

      //This for now only does this week
      $sql = "SELECT * FROM `reminders` WHERE 
              userid =$tempUser AND
              date >= CURRENT_DATE() - INTERVAL DAYOFWEEK(CURRENT_DATE()) - (1 + $weekNumber) DAY
              AND date <= CURRENT_DATE() - INTERVAL DAYOFWEEK(CURRENT_DATE()) - (7 + $weekNumber) DAY";

          if($classResult = mysqli_query($conn, $sqlC))
          $allClasses = mysqli_fetch_assoc($classResult);
          else 
          {
          $allClasses = null;
          echo "Error getting classes";
          }

      if($result = mysqli_query($conn, $sql))
      {
          //Grabs the result in an array and print them all 
      if ($row = mysqli_fetch_assoc($result)) 
      {
        if(empty($row))
        echo "erroaar";

          PrintTableWithData($result, $weekNumber, $classResult);
      }
      else{
        PrintTableWithData(null,$weekNumber , $classResult);
      }
      } else{
        echo "error";
      }
      mysqli_free_result($result);
    }

    function PrintTableWithData($data , $weekNumber, $classData)
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

     // if(empty($data) || $data==null) //it is empty just show the other thing
     if(false) //Just getting rid of this, there is no need
      {
      //  PrintFullEmptyTable( $ifCurrentDay); //Idk if this is the right way tho, test later
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
       if($data !=null)
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

      //Converting class data here
      #region
      //0 Sunday, 1 Monday etc
      $allClassesT = array( 
        //Monday 
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

      $classSlotNumber = array();
      if($classData != null)
      foreach($classData as $eachClass)
      {
       // echo $eachClass['name'] . " ";
        //Here checking each class and detecting how many times it repeats?
        //This checks just the 6 reminders in the thing
        for ($i=1; $i<=6 ; $i++) 
        { 

          $day = "timeD".$i;
          $startT = "timeS".$i;
          $endT = "timeE".$i;
        //  echo $eachClass[$day] . " ";
          if($eachClass[$day] >0) //Use the day to check if the time is valid only
          {
            $tempNumb = $eachClass[$day] -1;
            $tempString = $eachClass['name'] . "\n";

            //From here just check to get all the items added to the thingy
            
            $timePointer = date_parse($eachClass[$startT])['hour'];
            $endPoint = date_parse($eachClass[$endT])['hour'];

            //Calculating in here the middle point so I know when to print the title
            $totalPoints =   $endPoint - $timePointer;
            $totalPoints ++; //This fixes stuff
            $p1 = 0;
            $p2 = 0;

            if($totalPoints%2 ==0) //If its a pair number
            {
              $p1 = ($totalPoints / 2);
              $p2 = $p1 + 1;
            } 
            else //Odd number
            {
              $p1 = (round($totalPoints / 2));
              $p2 = -1;
            }

         
            //Now get all the slots from that to the end added to the array
            for ($u=$timePointer, $x =1; $u <= $endPoint ; $u++ , $x++) 
            { 
              $dayS = $tempNumb;
              $Oslot = getTimeSlotWithHour($u);
              $Islot = getInnerTimeSlotWithHour($u);

              $allClassesT[$dayS][$Oslot][$Islot] = $eachClass;

             // $classSlotNumber[$dayS."-".$Oslot."-".$Islot] = $x;

              if($x == round($p1) && $p2 != -1)
              $classSlotNumber[$dayS."-".$Oslot."-".$Islot] = "M1";

              else if($x == round($p1) && $p2 == -1)
              $classSlotNumber[$dayS."-".$Oslot."-".$Islot] = "M0";

              if($x == round($p2))
              $classSlotNumber[$dayS."-".$Oslot."-".$Islot] = "M2";
              //The key is going to be DAY-SLOT-ISLOT and the value is the slot number
              
              //echo " Day: ".$tempNumb ." Slot: ".getTimeSlotWithHour($u) . " innerSlot: ".getInnerTimeSlotWithHour($u) ." Content: ".$allClassesT[$tempNumb][getTimeSlotWithHour($u)][getInnerTimeSlotWithHour($u)] . " | ";
            }
            //$allClassesT[$tempNumb][getInnerTimeSlot()] = $tempString; 
          }
          
        }
        

      }
      
      
  
      
      #endregion

  

       //Start building the table here

       $rmds;
       $end = "";
       $hideFirst = "";
       for($x=0;$x<4;$x++)
       {
        //do all che checks here
                //Add here the last row
                if($x==0)
                {
                  $end="<th style='padding: 0px;'> 
                          <table style='width:100%;height: 100%;'> 
                  <tr style='border: 1px solid grey'> <td> 00:00&nbsp;AM </td></tr>
                  <tr style='border: 1px solid grey'> <td > 01:00&nbsp;AM</td></tr>
                  <tr style='border: 1px solid grey'> <td > 02:00&nbsp;AM</td></tr>
                  <tr style='border: 1px solid grey'> <td > 03:00&nbsp;AM</td></tr>
                  <tr style='border: 1px solid grey'> <td > 04:00&nbsp;AM</td></tr>
                  <tr style='border: 1px solid grey'> <td > 05:00&nbsp;AM</td></tr>
                  </table>
                   
                  </th> ";
                  $hideFirst = "style='display:none;'"; //TODO: Later have this as a setting to unhide it
                } 
                else if($x==1)
                {
                  $end= " 
                  <th style='padding: 0px;'>  <table style='width:100%;height: 100%;'> 
                  <tr style='border: 1px solid grey'> <td > 06:00&nbsp;AM </td></tr>
                  <tr style='border: 1px solid grey'> <td > 07:00&nbsp;AM</td></tr>
                  <tr style='border: 1px solid grey'> <td > 08:00&nbsp;AM</td></tr>
                  <tr style='border: 1px solid grey'> <td > 09:00&nbsp;AM</td></tr>
                  <tr style='border: 1px solid grey'> <td > 10:00&nbsp;AM</td></tr>
                  <tr style='border: 1px solid grey'> <td > 11:00&nbsp;AM</td></tr>
                  </table></th> 
                  ";
                  $hideFirst ="";
                }  
                else if($x==2)
                {
                  $end= "<th style='padding: 0px;'>  <table style='width:100%;height: 100%;'> 
                  <tr style='border: 1px solid grey'> <td > 12:00&nbsp;PM </td></tr>
                  <tr style='border: 1px solid grey'> <td > 01:00&nbsp;PM</td></tr>
                  <tr style='border: 1px solid grey'> <td > 02:00&nbsp;PM</td></tr>
                  <tr style='border: 1px solid grey'> <td > 03:00&nbsp;PM</td></tr>
                  <tr style='border: 1px solid grey'> <td > 04:00&nbsp;PM</td></tr>
                  <tr style='border: 1px solid grey'> <td > 05:00&nbsp;PM</td></tr>
                  </table></th>";
                  $hideFirst ="";
                }
                else 
                {
                  $end= "<th style='padding: 0px;'>  <table style='width:100%;height: 100%;'> 
                  <tr style='border: 1px solid grey'> <td > 06:00&nbsp;PM </td></tr>
                  <tr style='border: 1px solid grey'> <td > 07:00&nbsp;PM</td></tr>
                  <tr style='border: 1px solid grey'> <td > 08:00&nbsp;PM</td></tr>
                  <tr style='border: 1px solid grey'> <td > 09:00&nbsp;PM</td></tr>
                  <tr style='border: 1px solid grey'> <td > 10:00&nbsp;PM</td></tr>
                  <tr style='border: 1px solid grey'> <td > 11:00&nbsp;PM</td></tr>
                  </table></th>";
                  $hideFirst ="";
                }


                //The wrapper for the formating
     
                

        echo "<tr  $hideFirst>";
        for($y=0;$y<7;$y++)
        {

          echo"<td style='padding: 0px;' $ifCurrentDay[$y]>";
         
          $temp ="";
          $timeSlots = array();
          //This prints the button for the reminder
              #region
              foreach($allReminders[$y][$x] as $val)
              {
                //This appearts to work just fine, which is kinda weird but whatever
                  $timeTemp = date("h:ia",strtotime($val["time"]));
                  
                  //Checkin for the priority
                  $colorTemp;
                  switch ($val['priority']) 
                  {
                    case 'High':
                      $colorTemp = "btn-warning";
                      break;

                      case 'Medium':
                        $colorTemp = "btn-success";
                        break;

                        case 'Low':
                          $colorTemp = "btn-info";
                          break;
                    
                    default:
                    $colorTemp = "btn-light";
                      break;
                  }


                  $temp = "<button class='btn ".$colorTemp."' type='button' onclick='showReminderInfoModal(".$val['id'].")' data-bs-toggle='modal' data-bs-target='#ReminderEditModel' id ='".$val['id']."'style='width:100%;'> <i class='fas fa-check fa-sm'></i> &nbsp;".$val["title"] ."</button>";
                  
                  //Now select where the button will be exactly 

                 // echo $temp; This will only print the last reminder in the selected slot
                 $timeSlots[getInnerTimeSlot($val)] = $temp;
                  
              }
              #endregion


          //This is my inner table and will check the hour
          echo"<table style='width:100%;height: 100%; border-collapse: collapse;
          border-style: hidden;'>";
          
         
          for ($i=0; $i < 6; $i++) 
          { 
            echo "<tr>";
            if(isset($timeSlots[$i]))
            echo "<td style='height:50px; 
            border: 1px solid #363b3e; '>".$timeSlots[$i];
            else //If there is a reminder already there I guess dont add it?
            {
              $tempT = "&nbsp;";
              $tempC = "";
              $tempClass ="";
              $tempID = "";
              //In here I do all the formating for the classes
             if (isset($allClassesT[$y][$x][$i]))
             {


              
              $tempC = "background-color: ".$allClassesT[$y][$x][$i]['color'].";";
              $tempClass = "class='formatMe'";

              //Accesing the slot number
              if(isset($classSlotNumber[$y."-".$x."-".$i]))
              {
                $tempSNum = $classSlotNumber[$y."-".$x."-".$i];

                if($tempSNum == "M1")
                {
                  $tempT ="<i class='fas fa-graduation-cap'></i> &nbsp;".$allClassesT[$y][$x][$i]['name']; 
                } else if($tempSNum == "M2")
                {
                  $tempT ="(".$allClassesT[$y][$x][$i]['type'].")";
                } else if ($tempSNum == "M0")
                {
                  $tempT ="<i class='fas fa-graduation-cap'></i> &nbsp;".$allClassesT[$y][$x][$i]['name'] ." <br>". "(".$allClassesT[$y][$x][$i]['type'].")"; 
                }


                
                
              } else 
              {
                $tempSNum ="";
              }
             
              //This is the ID, it might not be necessary
              $tempID = "id='c".$allClassesT[$y][$x][$i]['id']."-".$tempSNum."'";
             }
             

              echo "<td style='height:50px;
              border: 1px solid #363b3e; ".$tempC."'".$tempClass." ".$tempID." > ".$tempT;
            }
            
            echo "</tr> </td>";
          }
          
          
          
          echo "</table> ";

          
          
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
    //Might wanna change this so it actually sets the reminder inside of the hour that is needed?
    function getTimeSlot($value)
    {
      $a = $value["time"];
      $t = date_parse($a)['hour']; //This parses the hour
       //If it is in the morning I have to 
       if($t >= 6 && $t <12)
       {
         return 1; //Morning
       } else if($t >= 12 && $t < 18)
       {
        return 2; //Afternoon
       } else if($t >= 18 && $t <= 24)
       {
        return 3; //Evening
       } else {
        return 0; //Night
       }
    }
    function getInnerTimeSlot($value)
    {
      $a = $value["time"];
      $t = date_parse($a)['hour']; 

      for ($i=0; $i < 6; $i++) { 
        if($t == (0 + $i) || $t == (6 + $i) || $t == (12 +$i) || $t== (18 + $i))
          return $i;
      }
      
      
    }

    function getTimeSlotWithHour ($t)
    {
      if($t >= 6 && $t <12)
       {
         return 1; //Morning
       } else if($t >= 12 && $t < 18)
       {
        return 2; //Afternoon
       } else if($t >= 18 && $t <= 24)
       {
        return 3; //Evening
       } else {
        return 0; //Night
       }
    }

    function getInnerTimeSlotWithHour( $hour)
    {
      for ($i=0; $i < 6; $i++) { 
        if($hour == (0 + $i) || $hour == (6 + $i) || $hour == (12 +$i) || $hour== (18 + $i))
          return $i;
      }
    }

    function PrintDayTable($data , $classData, $day, $dayN)
    {
      //Print the data as reminders and the day as the current day, thats all
      switch($dayN)
      {
        case 1: $dayN = "Sunday"; break;
        case 2: $dayN = "Monday"; break;
        case 3: $dayN = "Tuesday"; break;
        case 4: $dayN = "Wednesday"; break;
        case 5: $dayN = "Thurday"; break;
        case 6: $dayN = "Friday"; break;
        case 7: $dayN = "Saturday"; break;
        default: $dayN ="Error"; break;
      }

      echo "<th> $dayN <br> $day </th> <th style='width: 150px;'> ... </th>";

      $allReminders = array();

    
       if($data !=null)
      foreach($data as $value)
      {
          $hour = substr($value['time'],0,2);
          $allReminders[$hour]= $value;
      
      }

      $allClassesT = array();
      $classSlotNumber = array();

      if($classData !=null)
      foreach($classData as $eachClass)
      {
        for($i=1; $i <=6; $i++)
        {
          //$day = "timeD".$i; //I dont need the day tbh
          $startT = "timeS".$i;
          $endT = "timeE".$i;

          $startHour = intval(substr($eachClass[$startT],0,2));
          $endHour = intval(substr($eachClass[$endT],0,2));

          //In here we check each of the times for the classes

          if($startHour < $endHour) //The only check for input
          {
            $totalPoints = $endHour - $startHour;
            $totalPoints++;
            
            $p1 = 0;
            $p2 = 0;

            if($totalPoints%2 ==0) //If its a pair number
            {
              $p1 = ($totalPoints / 2);
              $p2 = $p1 + 1;
            } 
            else //Odd number
            {
              $p1 = (round($totalPoints / 2));
              $p2 = -1;
            }

              for ($u=$startHour, $x =1; $u <= $endHour; $u++ , $x++) 
              { 

                $allClassesT[$u] = $eachClass;

                if($x == round($p1) && $p2 != -1)
                $classSlotNumber[$u] = "M1";

                else if($x == round($p1) && $p2 == -1)
                $classSlotNumber[$u] = "M0";

                if($x == round($p2))
                $classSlotNumber[$u] = "M2";
              }
          }
    
        }
      }


      //Now just check for the right slot and it should be okay
      for($x = 0; $x<24; $x++)
      {
          $y = $x +1;
          
          $actualTime = $y;
          $timeF = "AM";
          

          if($y >12)
          {
            $actualTime =  $actualTime - 12;
            $timeF ="PM";
          }

          $hideIt ="";
          if($y < 6 || $y >22) //Make this a toggle lter
          $hideIt= "style='display: none;'";


          if(isset($allReminders[$y]))
          {
            $a = $allReminders[$y]['title'];
            $colorTemp;
                  switch ($allReminders[$y]['priority']) 
                  {
                    case 'High':
                      $colorTemp = "btn-warning";
                      break;

                      case 'Medium':
                        $colorTemp = "btn-success";
                        break;

                        case 'Low':
                          $colorTemp = "btn-info";
                          break;
                    
                    default:
                    $colorTemp = "btn-light";
                      break;
                  }
            $temp = "<button class='btn ".$colorTemp."' type='button' onclick='showReminderInfoModal(".$allReminders[$y]['id'].")' data-bs-toggle='modal' data-bs-target='#ReminderEditModel' id ='".$allReminders[$y]['id']."'style='width:100%;'> <i class='fas fa-check fa-sm'></i> &nbsp;".$allReminders[$y]["title"] ."</button>";
            echo "<tr $hideIt> <td>$temp </td> <th > $actualTime:00&nbsp;$timeF</th> </tr> ";
          } 
          else if(isset($allClassesT[$y]))
          {
            $tempC = "style='background-color: ".$allClassesT[$y]['color'].";'";
            $tempClass = "class='formatMe'";
            $tempT = "&nbsp;";
              if(isset($classSlotNumber[$y]))
              {
                $tempSNum = $classSlotNumber[$y];

                if($tempSNum == "M1")
                {
                  $tempT ="<i class='fas fa-graduation-cap'></i> &nbsp;".$allClassesT[$y]['name']; 
                } else if($tempSNum == "M2")
                {
                  $tempT ="(".$allClassesT[$y]['type'].")";
                } else if ($tempSNum == "M0")
                {
                  $tempT ="<i class='fas fa-graduation-cap'></i> &nbsp;".$allClassesT[$y]['name'] ." <br>". "(".$allClassesT[$y]['type'].")"; 
                }

              } else
              {
                $tempSNum = "";
              }

              $tempID = "id='c".$allClassesT[$y]['id']."-".$tempSNum."'";

            echo "<tr $hideIt> <td $tempC $tempClass $tempID> $tempT </td> <th > $actualTime:00&nbsp;$timeF</th> </tr> ";
          }
          else 
          {
            echo "<tr $hideIt> <td> </td> <th > $actualTime:00&nbsp;$timeF</th> </tr> ";
          }
         
        

        
      }
    }
?>
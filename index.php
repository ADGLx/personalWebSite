<?php
  include_once 'includes/ConectSQL.php';
  session_start();
  //Set the session variable for the week
  if(isset($_GET["weeknmb"]) && !empty($_GET['weeknmb']))
  {
    $_SESSION["curWeek"] = $_GET["weeknmb"];
  } else {
    $_SESSION["curWeek"] = 0;
  }
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="MyStyle.css">
   
    <!--Favicon-->
    <link rel="icon" href ="img/creature.gif">
    <!--Boostrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!--Jquery import-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    


    <title>ADGL- MySchedule</title>
</head>
<body>
    <!--Login Verification-->
    <?php include("includes/accountVal.php"); ?>
   
    <!--Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
      <img src="/img/creature.gif" width="35" height="35" >
      <?php 
        $temp = $_SESSION["userUsername"];
          $temp = strtoupper($temp);
      echo "<a class='navbar-brand' href='#'>$temp&#39;s Schedule</a> "?>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link disabled" href="#">Coming Soon</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Settings
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="#">Account Settings</a></li>
                <li><a class="dropdown-item" href="#">General Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="/includes/logout.php">Log Out</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
      

    <!--Body-->
    <br class="container">
        <!--Leave a bit of empty space-->
        <div class="m-2"> <!--For the Margin-->
          
          <!--Add Class and Reminder buttons-->
          <button type="button" class="btn btn-dark buttonOverride disabled" style="width: 49.9%;" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Class</button>
          <button type="button" class="btn btn-dark buttonOverride" style="width: 49.9%; float: right;" data-bs-toggle="modal" data-bs-target="#ReminderModel">Add Reminder</button>

          <div class="table-responsive"> 
            <table class="table table-dark table-bordered" style="text-align: center;">
                <thead>
                  <tr>
                    <th colspan="8">
                      <form onsubmit="remove()" actions="includes/getWeeksReminders.php" method="GET">
                      <button type="submit" class="btn btn-success" style="float: inline-start;" name="weeknmb" id="minusWeek"  value=0 ><</button>
                      </form>
                     
                      <form onsubmit="add()" actions="includes/getWeeksReminders.php" method="GET">
                      Weekly Schedule 
                       <button type="submit" class="btn btn-success" style="float: inline-end;" name="weeknmb" id="plusWeek" value=0> ></button>
                       </form>
                      </th>
                  </tr>
                </thead>
                <tbody class ="align-middle h">

                  <?php include("includes/getWeeksReminders.php"); ?>


                </tbody>
              </table>
            </div>
            
            <!--Reminders Table-->
          <table class="table table-dark">
            <thead>
              <tr>
                <th>This Week's Reminders</th>
                <th>Date</th>
                <th>Time</th>
                <th>Description</th>
                <th>Options </th>
              </tr>
            </thead>
            <tbody>
            <?php include ("includes/getReminder.php"); ?>
            </tbody>
          </table>

         
        </div>
    
    </div>

     <!--Footer-->
  <div class ="footer">
   <!--<p> By Alvaro Gonzalez</p> --> 
</div>

 <!-- Modal For Opening Class -->
<div class="container">
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add a Class &nbsp;</h5> 
          <!--Color-->
          <input type="color" id="head" name="head" value="#e66465" style="width: 60%; flex-grow:1;">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          
          <form>
            <!--Name-->
            <div>
              <label for="classname">Class name: </label>
              <input type="text" id="classname" name="fname" style="width: 75%; float: inline-end;">
            </div>
            <br>
            <!--Class Times-->
            <div>
              <table style="width: 100%;">
                <tr>
                  <!--Gotta add one to the row span to make it work-->
                    <td rowspan="3">  <label for="classtimes"> Class times: </label> <br><button type="button" class="btn btn-dark btn-sm"> Add</button></td>
                    <td><input type="time" id="timestart1" name="timestart1" style="width: 35%;"> to <input type="time" id="timestart1" name="timestart1" style="width: 35%;"> </td>
                </tr>
                <!--Add this as a new thing for the time-->
                <tr>
                  <td><input type="time" id="timestart1" name="timestart1" style="width: 35%;"> to <input type="time" id="timestart1" name="timestart1" style="width: 35%;"> <button type="button" class="btn btn-dark btn-sm"> x</button> </td>
                </tr>
                 <!--Add this as a new thing for the time-->
                 <tr>
                  <td><input type="time" id="timestart1" name="timestart1" style="width: 35%;"> to <input type="time" id="timestart1" name="timestart1" style="width: 35%;"> <button type="button" class="btn btn-dark btn-sm"> x</button> </td>
                </tr>
              </table>
            </div>
            <br>
            <!--Type-->
            <div>
              <label  for="inlineFormCustomSelectPref">Type:</label>
              <select id="inlineFormCustomSelectPref" style="width: 75%; text-align: center; float: inline-end;">
                <option value="1">Tutorial</option>
                <option value="2">Lecture</option>
                <option value="3">Lab</option>
              </select>
            </div>
            <br>
            <!--Location-->
            <div>
              <label for="classname">Location: </label>
              <input type="text" id="classname" name="fname" style="width: 75%; float: inline-end;">
            </div>
            <br>
           <!--Description-->
           <div>
            <label for="classname">Description: </label>
            <input type="textbox" id="classname" name="fname" style="width: 75%; height: 50px; float: inline-end;">
          </div>

          </form>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Modal For Opening reminder -->
<form action="includes/submitReminder.php" method="POST">
<div class="container">
  <div class="modal fade" id="ReminderModel" tabindex="-1" aria-labelledby="ReminderModel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">    
      <div class="modal-header">
          <h5 class="modal-title" id="ReminderModel">Add a Reminder &nbsp;</h5> 
          
          <!--Color-->
          <input type="color" id="head" name="rmdColor" value="#e66465" >
         
        </div>
        <div class="modal-body">
            <!--Name-->
            <div>
              <label for="classname">Title: </label>
              <input type="text" id="classname" name="rmdTitle" style="width: 75%; float: inline-end;">
            </div>
            <br>
            <!--Class Times-->
            <div>
              <table style="width: 100%;">
                <tr>
                  <!--Gotta add one to the row span to make it work-->
                    <td>  <label for="classtimes">Time: </label> </td>
                    <td><input type="time" id="timestart1" name="rmdTime" style="width: 100%;"></td>
                </tr>

              </table>
            </div>
            <br>
            <!--Date-->
            <div>
              <label>Date: </label>
              <input type="date" id="datereminder" name="rmdDate" style="width: 80%; float: inline-end;"> 
            </div>
           
            <br>
            <!--Type-->
            <div>
              <label  for="inlineFormCustomSelectPref">Priority</label>
              <select id="inlineFormCustomSelectPref" name="rmdPriority" style="width: 75%; text-align: center; float: inline-end;">
                <option value="High">High</option>
                <option value="Medium">Medium</option>
                <option value="Low">Low</option>
              </select>
            </div>
            <br>
            <!--Location-->
            <div>
              <label>Notify by email: </label>
              <input type="checkbox" id="classname" name="rmdNotify" checked="on" style="float: inline-end;">
            </div>
            <br>
           <!--Description-->
           <div>
            <label for="classname">Description: </label>
            <input type="textbox" id="classname" name="rmdDescription" style="width: 75%; height: 50px; float: inline-end;">
          </div>

          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button submit" class="btn btn-primary" data-bs-dismiss="modal" name="submit">Save changes</button>
        </div>
      </div>
    </div>
  </div>
</div>
</form>

<!-- Modal for Editing Reminder -->
<form action="includes/editReminder.php" method="POST">
<div class="container" id="editReminder">
<div class='modal fade' id='ReminderEditModel' tabindex='-1' aria-labelledby='ReminderEditModel' aria-hidden='true'>
             <div class='modal-dialog'>
               <div class='modal-content'>    
               <div class='modal-header'>
                   <h5 class='modal-title' id='ReminderEditModel'>Edit a Reminder &nbsp;</h5> 
                   
                   <!--Color-->
                   <input type='color' id='colorE' name='rmdColor' value='#e66465' >
                  
                 </div>
                 <div class='modal-body'>
                     <!--Name-->
                     <div>
                       <label for='titleE'>Title: </label>
                       <input type='text' id='titleE' name='rmdTitle' style='width: 75%; float: inline-end;'>
                     </div>
                     <br>
                     <!--Class Times-->
                     <div>
                       <table style='width: 100%;'>
                         <tr>
                           <!--Gotta add one to the row span to make it work-->
                             <td>  <label for='classtimesE'>Time: </label> </td>
                             <td><input type='time' id='timeE' name='rmdTime' style='width: 100%;'></td>
                         </tr>
         
                       </table>
                     </div>
                     <br>
                     <!--Date-->
                     <div>
                       <label>Date: </label>
                       <input type='date' id='dateE' name='rmdDate' style='width: 80%; float: inline-end;'> 
                     </div>
                    
                     <br>
                     <!--Type-->
                     <div>
                       <label  for='inlineFormCustomSelectPref'>Priority</label>
                       <select id='priorityE' name='rmdPriority' style='width: 75%; text-align: center; float: inline-end;'>
                         <option value='High'>High</option>
                         <option value='Medium'>Medium</option>
                         <option value='Low'>Low</option>
                       </select>
                     </div>
                     <br>
                     <!--Location-->
                     <div>
                       <label>Notify by email: </label>
                       <input type='checkbox' id='notifyE' name='rmdNotify' checked='on' style='float: inline-end;'>
                     </div>
                     <br>
                    <!--Description-->
                    <div>
                     <label for='classname'>Description: </label>
                     <input type='textbox' id='descriptionE' name='rmdDescription' style='width: 75%; height: 50px; float: inline-end;'>
                   </div>
         
                   
                 </div>
                 <div class='modal-footer'>
                   <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                   <button type='button submit' class='btn btn-primary' data-bs-dismiss='modal' name='submit' id='editR'>Save changes</button>
                 </div>
               </div>
             </div>
           </div>
</div>
</form>

    <!--Boostrap JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!--My Own JS-->
   <script src="changeWeek.js"></script> 
   <script src="variousFunctions.js"></script> 

</body>
</html>
<!--Closes the connection to SQL at the end-->
<?php include("includes/disconnectSQL.php"); ?>

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
    
   
    <!--Favicon-->
    <link rel="icon" href ="img/creature.png">
    <!--Boostrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!--Jquery import-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
    <!--Font Awesome-->
    <script src="https://kit.fontawesome.com/0eb434093d.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="NewCSS.css">


    <title>Scheduler</title>
</head>
<body onload="showToDoTypes(); showSchedule(0); showReminderList();">
    <!--Login Verification-->
    <?php include("includes/accountVal.php"); ?>

    <!--Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
      <img src="/img/creature.png" width="35" height="35" >
      <?php 
        $temp = $_SESSION["userUsername"];
          $temp = strtoupper($temp);
      echo "<a class='navbar-brand' href='index.php'>$temp&#39;s Schedule </a> "?>
        
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
              <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#classesList">Classes List</a></li>
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


            <table class ="table table-dark mb-0 table-bordered">
            <thead>
                <tr>
                   
                  <th style="text-align:center;" colspan=4> 
                  <button type="button" data-bs-toggle="modal" data-bs-target="#todosTypesList" class="btn btn-success btn-sm" style="float:left;"><i class="far fa-edit"></i></button>
                  To-Do Lists &nbsp; <i class="fas fa-list-ul"></i>
                  <button type="button" data-bs-toggle="modal" data-bs-target="#addTodo" class="btn btn-success btn-sm" style="float:right;"><i class="far fa-plus-square"></i></button> 
                </th>
                  
                </tr>
                </thead>
                <!--Get the button amount from here -->
                <tbody id="todoTypeParent" class="hoverTitle ">
                <?php //include_once("includes/getToDoLists.php");?>
                </tbody>
            </table>
            <!-- the format of the table is changed via js-->
            <table id='addTodosTable' class="table table-sm table-dark ht">
            </table>
 
      
          <!--Add Class and Reminder buttons-->
          <button type="button" class="btn btn-dark buttonOverride" style="width: 49.9%;" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Class &nbsp; <i class="fas fa-graduation-cap"></i></button>
          <button type="button" class="btn btn-dark buttonOverride" style="width: 49.9%; float: right;" data-bs-toggle="modal" data-bs-target="#ReminderModel">Add Reminder &nbsp;<i class='fas fa-check fa-sm'></i></button>

          <div class="table-responsive selectable"> 
            <table class="table table-dark table-bordered" style="text-align: center; height:100%; width: 100%;">
                <thead>
                  <tr>
                    <th colspan="8">
                      <button  class="btn btn-success" onclick="showSchedule(-1); showReminderList();" style="float: left;" name="weeknmb" id="minusWeek"  value=0 > <i class="fas fa-arrow-left"></i> </button>
                      Weekly Schedule 
                       <button  class="btn btn-success" onclick="showSchedule(1); showReminderList();" style="float: right;" name="weeknmb" id="plusWeek" value=0> <i class="fas fa-arrow-right"></i></button>
    
                      </th>
                  </tr>
                </thead>
                <tbody class ="align-middle" id="scheduleTable">

                  <?php // include_once("includes/getWeeksReminders.php"); ?>


                </tbody>
              </table>
            </div>
            
  <!--Reminders Table-->
  <table class="table table-dark" id="reminderListTable">
            <?php //include ("includes/getReminder.php"); ?>
          </table>  
        </div>
    </div>


      <footer class="footer bg-dark">

      <!-- Copyright -->
      <div class="footer text-center py-2 text-muted">By Alvaro Gonzalez:
        <a href="https://abt.adgl.tech/" class="text-muted"> abt.adgl.tech</a>
      </div>

      </footer>

 <!-- Modal For Opening Class -->
 <form action="includes/submitClass.php" method="POST">
<div class="container">
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add a Class &nbsp;</h5> 
          <!--Color-->
          <input type="color" id="color" name="color" value="#e66465" style="width: 15%; display: flex; margin-left: auto; ">
        </div>
        <div class="modal-body">
          
         
            <!--Name-->
            <div>
              <label for="name">Class name: </label>
              <input type="text" id="name" name="name" style="width: 75%; float: inline-end;">
            </div>
            <br>
            <!--Class Times-->
            <div>
              <table style="width: 100%;">
                <tr>
                  <!--Gotta add one to the row span to make it work-->
                    <td rowspan="6">  <label for="classtimes"> Class times: </label> </td>
                    <td><input type="time" id="timeS1" name="timeS1" style="width: 35%;"> to <input type="time" id="timeE1" name="timeE1" style="width: 35%;"> 
                      <select id="inlineFormCustomSelectPref" name="timeD1">
                      <option value="0"></option>
                        <option value='1'>1-S</option>
                        <option value='2'>2-M</option>
                        <option value='3'>3-T</option>
                        <option value='4'>4-W</option>
                        <option value='5'>5-T</option>
                        <option value='6'>6-F</option>
                        <option value='7'>7-S</option>
                      </select>
                    </td>
                </tr>
                <!--Add this as a new thing for the time-->
                <tr>
                  <td><input type="time" id="timeS2" name="timeS2" style="width: 35%;"> to <input type="time" id="timeE2" name="timeE2" style="width: 35%;">  
                
                  <select id="inlineFormCustomSelectPref" name="timeD2">
                  <option value="0"></option>
                        <option value='1'>1-S</option>
                        <option value='2'>2-M</option>
                        <option value='3'>3-T</option>
                        <option value='4'>4-W</option>
                        <option value='5'>5-T</option>
                        <option value='6'>6-F</option>
                        <option value='7'>7-S</option>
                      </select>
                  </td>
                </tr>
                 <!--Add this as a new thing for the time-->
                 <tr>
                  <td><input type="time" id="timeS3" name="timeS3" style="width: 35%;"> to <input type="time" id="timeE3" name="timeE3" style="width: 35%;">  
                  <select id="inlineFormCustomSelectPref" name="timeD3">
                  <option value="0"></option>
                        <option value='1'>1-S</option>
                        <option value='2'>2-M</option>
                        <option value='3'>3-T</option>
                        <option value='4'>4-W</option>
                        <option value='5'>5-T</option>
                        <option value='6'>6-F</option>
                        <option value='7'>7-S</option>
                      </select>
                
                </td>
                </tr>
                 <!--Add this as a new thing for the time-->
                 <tr>
                  <td><input type="time" id="timeS4" name="timeS4" style="width: 35%;"> to <input type="time" id="timeE14" name="timeE4" style="width: 35%;">  
                  <select id="inlineFormCustomSelectPref" name="timeD4">
                  <option value="0"></option>
                        <option value='1'>1-S</option>
                        <option value='2'>2-M</option>
                        <option value='3'>3-T</option>
                        <option value='4'>4-W</option>
                        <option value='5'>5-T</option>
                        <option value='6'>6-F</option>
                        <option value='7'>7-S</option>
                      </select>
                </td>
                </tr>
                 <!--Add this as a new thing for the time-->
                 <tr>
                  <td><input type="time" id="timeS5" name="timeS5" style="width: 35%;"> to <input type="time" id="timeE5" name="timeE5" style="width: 35%;">  
                  <select id="inlineFormCustomSelectPref" name="timeD5">
                  <option value="0"></option>
                        <option value='1'>1-S</option>
                        <option value='2'>2-M</option>
                        <option value='3'>3-T</option>
                        <option value='4'>4-W</option>
                        <option value='5'>5-T</option>
                        <option value='6'>6-F</option>
                        <option value='7'>7-S</option>
                      </select>
                </td>
                </tr>
                 <!--Add this as a new thing for the time-->
                 <tr>
                  <td><input type="time" id="timeS6" name="timeS6" style="width: 35%;"> to <input type="time" id="timeE6" name="timeE6" style="width: 35%;">  
                  <select id="inlineFormCustomSelectPref" name="timeD6">
                  <option value="0"></option>
                        <option value='1'>1-S</option>
                        <option value='2'>2-M</option>
                        <option value='3'>3-T</option>
                        <option value='4'>4-W</option>
                        <option value='5'>5-T</option>
                        <option value='6'>6-F</option>
                        <option value='7'>7-S</option>
                      </select>
                </td>
                </tr>
              </table>
            </div>
            <br>
            <!--Type-->
            <div>
              <label  for="inlineFormCustomSelectPref">Type:</label>
              <select id="inlineFormCustomSelectPref" name="type" style="width: 75%; text-align: center; float: inline-end;">
                <option value="Tutorial">Tutorial</option>
                <option value="Lecture">Lecture</option>
                <option value="Lab">Lab</option>
              </select>
            </div>
            <br>
            <!--Location-->
            <div>
              <label for="location">Location: </label>
              <input type="text" id="location" name="location" style="width: 75%; float: inline-end;">
            </div>
            <br>
           <!--Description-->
           <div>
            <label for="description">Description: </label>
            <input type="textbox" id="description" name="description" style="width: 75%; height: 50px; float: inline-end;">
          </div>

   

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button submit" class="btn btn-primary" name='submit'>Save changes</button>
        </div>
      </div>
    </div>
  </div>
</div>
</form>


<!-- Modal For Opening reminder -->
<form action="includes/submitReminder.php" method="POST">
<div class="container">
  <div class="modal fade" id="ReminderModel" tabindex="-1" aria-labelledby="ReminderModel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">    
      <div class="modal-header">
          <h5 class="modal-title" id="ReminderModel">Add a Reminder &nbsp;</h5> 
          
          <!--Color-->
          <button type="button" id="reminderPreview" class="btn btn-warning">&nbsp; &nbsp; <i class="fas fa-check"></i> &nbsp; &nbsp; </button>
         
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
              <label >Priority</label>
              <select  id="reminderP" onchange="updateReminderPreviewColor()" name="rmdPriority" style="width: 75%; text-align: center; float: inline-end;">
                <option value="High">High</option>
                <option value="Medium">Medium</option>
                <option value="Low">Low</option>
              </select>
            </div>
            <br>
            <!--Location-->
            <div>
              <label>Notify by email: (15 minutes before)</label>
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
                   <button type="button" id="reminderPreviewE" class="btn btn-warning">&nbsp; &nbsp; <i class="fas fa-check"></i> &nbsp; &nbsp; </button>

                   <!--Delete-->
              
                    <button type="button delete" name="delete" class="btn btn-danger" id="deleteE" value=""><i class="far fa-trash-alt"></i> </button> 
                   
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
                       <select id='priorityE' onchange="updateReminderPreviewColorE()" name='rmdPriority' style='width: 75%; text-align: center; float: inline-end;'>
                         <option value='High'>High</option>
                         <option value='Medium'>Medium</option>
                         <option value='Low'>Low</option>
                       </select>
                     </div>
                     <br>
                     <!--Location-->
                     <div>
                       <label>Notify by email: (15 minutes before)</label>
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


<!-- Modal for Classes List -->
<div class="modal fade" id="classesList" tabindex="-1" aria-labelledby="classesListLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="classesListLabel">Classes List</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <table class="table">
       <tr> <th> Class Name </th>  <th> Options </th></tr>
      <?php include ("includes/classesList.php") ; ?>
      </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal for Todo Types List -->
<div class="modal fade" id="todosTypesList" tabindex="-1" aria-labelledby="todosTypesListLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="todosTypesListLabel">To-Dos List (4 max) </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <table class="table">
       <tr> <th> To-Do Type </th>  <th> Options </th></tr>
       <?php include ("includes/todosTypesList.php") ; ?>
      </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal for adding To-Dos Types -->
<form action="includes/submitToDoType.php" method="POST">
<div class="modal fade" id="addTodo" tabindex="-1" aria-labelledby="addTodoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addTodoLabel">Add To-Do Type (4 max) </h5>
         <!--Color-->
         <input type="color" id="color" name="color" value="#e66465" style="width: 15%; display: flex; margin-left: auto; ">
      </div>
      <div class="modal-body">
            <!--Text-->
            <div>
              <label>Text: </label>
              <input type="text" id="name" name="name" style="width: 75%; float: inline-end;">
            </div>
            <br>
      </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button submit" class="btn btn-primary" data-bs-dismiss="modal" name="submit">Save changes</button>
      </div>
    </div>
  </div>
</div>
</form>


    <!--Boostrap JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!--My Own JS-->
   <script src="variousFunctions.js"></script> 



  </body>


  </html>
<!--Closes the connection to SQL at the end-->
<?php include("includes/disconnectSQL.php"); ?>

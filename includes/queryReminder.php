<?php

session_start();//Not sure why but this works
require_once 'ConectSQL.php'; //Connects to the SQL
if(isset($_GET["editID"]) !=null)
{
    $id =  $_GET["editID"];
} else 
{
    $id = "Id not found";
}
   
    $sql = "SELECT * FROM `reminders` WHERE id =$id";
    if($result = mysqli_query($conn, $sql))
    {
        
        $row = $result -> fetch_assoc();

           //Delete the thingy and display the page again
           if($row["userid"] == $_SESSION["userid"])
           {
             $allOutput = "
             <div class='modal fade' id='ReminderEditModel' tabindex='-1' aria-labelledby='ReminderEditModel' aria-hidden='true'>
             <div class='modal-dialog'>
               <div class='modal-content'>    
               <div class='modal-header'>
                   <h5 class='modal-title' id='ReminderEditModel'>Edit a Reminder &nbsp;</h5> 
                   
                   <!--Color-->
                   <input type='color' id='head' name='rmdColor' value='#e66465' >
                  
                 </div>
                 <div class='modal-body'>
                     <!--Name-->
                     <div>
                       <label for='classnameE'>Title: </label>
                       <input type='text' id='classnameE' name='rmdTitle' style='width: 75%; float: inline-end;'>
                     </div>
                     <br>
                     <!--Class Times-->
                     <div>
                       <table style='width: 100%;'>
                         <tr>
                           <!--Gotta add one to the row span to make it work-->
                             <td>  <label for='classtimes'>Time: </label> </td>
                             <td><input type='time' id='timestart1' name='rmdTime' style='width: 100%;'></td>
                         </tr>
         
                       </table>
                     </div>
                     <br>
                     <!--Date-->
                     <div>
                       <label>Date: </label>
                       <input type='date' id='datereminder' name='rmdDate' style='width: 80%; float: inline-end;'> 
                     </div>
                    
                     <br>
                     <!--Type-->
                     <div>
                       <label  for='inlineFormCustomSelectPref'>Priority</label>
                       <select id='inlineFormCustomSelectPref' name='rmdPriority' style='width: 75%; text-align: center; float: inline-end;'>
                         <option value='High'>High</option>
                         <option value='Medium'>Medium</option>
                         <option value='Low'>Low</option>
                       </select>
                     </div>
                     <br>
                     <!--Location-->
                     <div>
                       <label>Notify by email: </label>
                       <input type='checkbox' id='classname' name='rmdNotify' checked='on' style='float: inline-end;'>
                     </div>
                     <br>
                    <!--Description-->
                    <div>
                     <label for='classname'>Description: </label>
                     <input type='textbox' id='classname' name='rmdDescription' style='width: 75%; height: 50px; float: inline-end;'>
                   </div>
         
                   
                 </div>
                 <div class='modal-footer'>
                   <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                   <button type='button submit' class='btn btn-primary' data-bs-dismiss='modal' name='submit'>Save changes</button>
                 </div>
               </div>
             </div>
           </div>
              ";

              echo $allOutput;
           }
          


    } else {
        echo "Error could not fetch data base ";
    }
   // header("location: ../index.php?message=".$id);
   

?>
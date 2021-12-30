<?php
$tempUser = $_SESSION["userid"];
require_once 'ConectSQL.php';

//----------------------------Gets the types--------------------------
#region
$sql ="SELECT * FROM todos_type WHERE userid=$tempUser";

if($result = mysqli_query($conn, $sql))
{
  $amt = 0;
  echo"<tr>";
  //We have a max of six types I guess
    while ($row = mysqli_fetch_assoc($result)) 
    {
      if($amt < 4)
      {
        $amt++;
        echo "
        <th class ='text-center w-25' id='color".$row['id']."' value='".$row['color']." ' style='background-color:".$row['color'].";' onclick='showToDoList(".$row['id'].")'> 
        ". $row['name']."
        </th> 
        ";
      }
     
    }
       
    for($x = $amt ; $x <4 ; $x++)
    {
      echo "
      <th class ='text-center w-25'> 
       
      </th> 
      ";
    }

    echo"</tr>";
} 
#endregion
//There is something wrong in the way this is printed

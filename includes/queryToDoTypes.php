<?php
session_start();
$tempUser = $_SESSION["userid"];
require_once 'ConectSQL.php';

$amtOfCol = 4;
if(isset($_GET['mobile']) && $_GET['mobile']==1)
{
    $amtOfCol = 2;
}


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
      if($amt < $amtOfCol)
      {
        $amt++; //Name is the ID Type?
        echo "
        <th class ='text-center w-25 bg-dark' name='".$row['id']."' id='color".$row['id']."' value='".$row['color']." ' style='color:".$row['color'].";' onclick='showToDoList(".$row['id'].")'> 
        ". $row['name']." &nbsp; <i id='icon".$row['id']."'class='fas fa-chevron-down'></i>
        </th> 
        ";
      }
     
    }
       
    for($x = $amt ; $x <$amtOfCol ; $x++)
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
?>
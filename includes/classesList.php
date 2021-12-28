<?php 
    $tempUser = $_SESSION["userid"];

    $sql ="SELECT * FROM classes WHERE userid=$tempUser";

    if($result = mysqli_query($conn, $sql))
    {
        while ($row = mysqli_fetch_assoc($result)) 
        {
            addClassReminderTable($row['name'], $row['id']);
        }
           

    } 
    else 
    {
        echo "Error at getting database";
    }

    mysqli_free_result($result);

    function addClassReminderTable($title, $id)
    {
        echo "
        <tr> 
        <form action='includes/deleteClass.php' method='POST'>
            <td> $title </td> 
            <td>
            <button class='btn btn-success btn-sm disabled' name='edit' ' >Edit</button>
            <button type='button delete' class='btn btn-danger btn-sm' name='delete' id ='$id' value='$id'>Delete</button> 
            </td>
        </form>
        </tr> ";
    }
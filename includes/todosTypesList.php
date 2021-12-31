<?php 
    $tempUser = $_SESSION["userid"];

    $sql ="SELECT * FROM todos_type WHERE userid=$tempUser";

    if($result = mysqli_query($conn, $sql))
    {
        while ($row = mysqli_fetch_assoc($result)) 
        {
            addTodosTypeTable($row['name'], $row['id']);
        }
           

    } 
    else 
    {
        echo "Error at getting database";
    }

    mysqli_free_result($result);

    function addTodosTypeTable($title, $id)
    {
        echo "
        <tr> 
        <form action='includes/deleteTodoType.php' method='POST'>
            <td> $title </td> 
            <td>
            <button class='btn btn-success btn-sm disabled' name='edit' ' >Edit</button>
            <button type='button delete' class='btn btn-danger btn-sm' name='delete' id ='$id' value='$id'>Delete</button> 
            </td>
        </form>
        </tr> ";
    }
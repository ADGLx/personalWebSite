<?php
//This will be executed by the server every minute or so
//This checks for the current reminders set 
 include "./includes/ConectSQL.php";
 
 //$myfile = fopen("newfile.txt", "a") or die("Unable to open file!");
 //fwrite($myfile, "this is a test \n");
 //fclose($myfile);

 //This works now I can run the php file from the server now I just have to connect to the SQL and get all the info
 $todaysDate = date("Y-m-d");
 $rn = date("h:m").":00"; //Ignore the seconds
 //15 minutes in advance
 $sql = "SELECT * FROM `reminders` WHERE  time = ADDTIME('$todaysDate $rn','00:15:00') AND date = $todaysDate AND notify = true"; //This for now just gets today's date

 //Now just send the email with the sql info

 if($result = mysqli_query($conn, $sql))
    {
        //Grabs the result in an array and print them all 
        while ($row = mysqli_fetch_assoc($result)) 
        {
            //Now for each of the grabbed results of the sql gotta check the other table
            $sql2 = "SELECT * FROM `logins` WHERE id ='" . $row["id"]. "'";

                if($result2 = mysqli_query($conn, $sql2))
                {
                    while($user = mysqli_fetch_assoc($result))
                    {
                        //This should execute only once so I will exit manually
                        mail($user["email"],$row["title"], $row["description"]);
                        break;
                    }
                }
        }
    } 

?>
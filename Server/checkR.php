<?php
//This will be executed by the server every minute or so
//This checks for the current reminders set 

//TODO: Make safe
//Connect to the DB, kinda ghetto way but whatever
$dbServername = "localhost";
$dbUserName = "root";
$dbPassword = "S3rverPassword"; 

$dbName= "loginsystem";

$conn = mysqli_connect($dbServername, $dbUserName, $dbPassword, $dbName);


 //This works now I can run the php file from the server now I just have to connect to the SQL and get all the info
 $todaysDate = date("Y-m-d");
 $rn = date("h:i").":00"; //Ignore the seconds
 $futureTime = date("h:i", strtotime("+15 minutes", strtotime($rn))).":00";
 //15 minutes in advance
 $sql = "SELECT * FROM reminders WHERE  time = $futureTime AND date = $todaysDate AND notify = true"; //This for now just gets today's date

 //Now just send the email with the sql info

 echo "Attempting to get reminders at $rn but that actually $futureTime on $todaysDate \n\n";

 if($result = mysqli_query($conn, $sql))
    {
        //echo "SQL Returned a result! \n";
        //Grabs the result in an array and print them all 
        while ($row = mysqli_fetch_assoc($result)) 
        {
            echo "SQL Returned a row! Now attempting to find user ". $row["userid"] ."\n";
            //Now for each of the grabbed results of the sql gotta check the other table
            $sql2 = "SELECT * FROM logins WHERE id ='" . $row["userid"]. "'";

                if($result2 = mysqli_query($conn, $sql2))
                {
                    echo "found reminder?\n";
                    if($user = mysqli_fetch_assoc($result2))
                    {
                        //This should execute only once so I will exit manually
                        echo "sending email to ". $user["email"]. " title: ". $row["title"] . " description: " . $row["description"];
                        mail($user["email"],$row["title"], $row["description"]);
                    }
                }
                else 
                {
                    echo "no user found with that id?\n";
                }
        }
    } else 
    {
        echo "no reminders found at $futureTime on $todaysDate \n";
    }


?>
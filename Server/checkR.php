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

date_default_timezone_set("America/Montreal");

 //This works now I can run the php file from the server now I just have to connect to the SQL and get all the info
 $todaysDate = date("Y-m-d");
 $rn = date("h:m").":00"; //Ignore the seconds
 //15 minutes in advance
 $sql = "SELECT * FROM `reminders` WHERE  time = ADDTIME('$todaysDate $rn','00:15:00') AND date = $todaysDate AND notify = true"; //This for now just gets today's date

 //Now just send the email with the sql info

 echo "Attempting to get reminders at $rn on $todaysDate \n\n";

 if($result = mysqli_query($conn, $sql))
    {
        //Grabs the result in an array and print them all 
        while ($row = mysqli_fetch_assoc($result)) 
        {
            //Now for each of the grabbed results of the sql gotta check the other table
            $sql2 = "SELECT * FROM `logins` WHERE id ='" . $row["userid"]. "'";

                if($result2 = mysqli_query($conn, $sql2))
                {
                    echo "found reminder but no user? \n";
                    while($user = mysqli_fetch_assoc($result))
                    {
                        //This should execute only once so I will exit manually
                        mail($user["email"],$row["title"], $row["description"]);
                        echo "sent email to ". $user["email"]. " title: ". $row["title"] . " description: " . $row["description"];
                        break;
                    }
                }
                else 
                {
                    echo "no user found with that id?\n";
                }
        }
    } else 
    {
        echo "no reminders found at $rn on $todaysDate";
    }


?>
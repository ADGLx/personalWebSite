<?php
//This will be executed by the server every minute or so
//This checks for the current reminders set 
 include "../includes/ConectSQL.php";
 
 //$myfile = fopen("newfile.txt", "a") or die("Unable to open file!");
 //fwrite($myfile, "this is a test \n");
 //fclose($myfile);

 //This works now I can run the php file from the server now I just have to connect to the SQL and get all the info
 $todaysDate = date("Y-m-d");
 $sql = " SELECT * FROM `reminders` WHERE date = '$todaysDate' "; //This for now just gets today's date

 //Now just send the email with the sql info

 if($result = mysqli_query($conn, $sql))
    {
        //Grabs the result in an array and print them all 
        while ($row = mysqli_fetch_assoc($result)) 
        {
            
        }
    } 

    //Just send a test email here
    mail("luismvl114@gmail.com", "Lo logre luis ", "el server te manda este mensaje");

?>
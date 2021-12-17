<?php
//This will be executed by the server every minute or so
//This checks for the current reminders set 
 include "../includes/ConectSQL.php";
 $myfile = fopen("newfile.txt", "a") or die("Unable to open file!");
 fwrite($myfile, "this is a test \n");
 fclose($myfile);
?>
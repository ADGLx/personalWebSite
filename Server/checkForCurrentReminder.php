<?php
//This will be executed by the server every minute or so
 include "includes ../includes/ConectSQL.php";
 $myfile = fopen("newfile.txt", "a") or die("Unable to open file!");
 fwrite($myfile, "this is a test");
 fclose($myfile);
?>
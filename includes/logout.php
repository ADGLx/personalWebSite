<?php
    session_start();
    session_unset();
    session_destroy();

    if(isset($_COOKIE['user']))
    {
        unset($_COOKIE['user']);
        setcookie('user', null, -1, '/'); 
    }
    

    if(isset($_COOKIE['pwd']))
    {
        unset($_COOKIE['pwd']);
        setcookie('pwd', null, -1, '/'); 
    }
    

    header ("location: ../LoginPage.php");
    exit();
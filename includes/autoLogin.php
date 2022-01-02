<?php

if(isset($_COOKIE['user']) && isset($_COOKIE['pwd']))
{
    require_once("login.php");
    require_once 'ConectSQL.php';
    LoginUser($conn, $_COOKIE['user'], $_COOKIE['pwd']);
   // echo($_COOKIE['user'] ."  ". $_COOKIE['pwd']);
    die();
}

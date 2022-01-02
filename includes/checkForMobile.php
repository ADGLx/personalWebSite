<?php 

//Check on first execution
    if(isMobileDev())
    {
        setcookie("scrnSize","small", time() +  (900), "/");
    } else 
    {
        setcookie("scrnSize","normal", time() +  (900), "/");
    }


function isMobileDev(){
    if(!empty($_SERVER['HTTP_USER_AGENT'])){
       $user_ag = $_SERVER['HTTP_USER_AGENT'];
       if(preg_match('/(Mobile|Android|Tablet|GoBrowser|[0-9]x[0-9]*|uZardWeb\/|Mini|Doris\/|Skyfire\/|iPhone|Fennec\/|Maemo|Iris\/|CLDC\-|Mobi\/)/uis',$user_ag)){
          return true;
       };
    };
    return false;
}
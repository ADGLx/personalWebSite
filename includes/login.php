<?php

    if(isset($_POST["submit"]))
    {
        $usn = $_POST['username'];
        $pwd = $_POST['password'];
        $rmb = $_POST['autologin'];

        require_once 'ConectSQL.php'; //Connects to the SQL

        if(emptyInputLogin($usn, $pwd) !== false)
        {
            header("location: ../LoginPage.php?error=emptyinput");
            exit();
        }

        //Set cookie if the rmb is true
        if($rmb !="") 
        {
            setcookie("user",$usn, time() +  (86400 * 30), "/"); //This is the user cookie
            setcookie("pwd",$pwd, time() +  (86400 * 30), "/");
        }

        loginUser ($conn, $usn, $pwd);


    } else 
    {
       // header("location: ../LoginPage.php");
       // exit();
    }


    function emptyInputLogin($userName, $password){
        if(empty($userName) || empty($password))
        {
            return true;
        } 
        else 
        {
            return false;
        }
    }

    function loginUser($conn, $usn, $pwd)
    {
        $userExist = usernameExist($conn, $usn, $pwd);

        if($userExist === false)
        {
            header("location: ../LoginPage.php?error=wronguser");
            exit();
        }

        $pwdHashed = $userExist["password"];

        //$checkPwd = password_verify($pwd, $pwdHashed); This didnt work

        if(!($pwd == $pwdHashed))
        {
            header("location: ../LoginPage.php?error=wrongpass");
            exit(); 
        } else
        {
            //sessions
            session_start();
            $_SESSION["userid"] = $userExist["id"];
            $_SESSION["userUsername"] = $userExist["user"];
            header("location: ../index.php");
        }
    }

    function usernameExist($conn, $usn)
    {
                //Check if username exists first
                $sql ="SELECT * FROM logins WHERE user =?;";//Question mark is a 
                $stmt = mysqli_stmt_init($conn);//Prepared statement
                if(!mysqli_stmt_prepare($stmt, $sql)){ //This is to check my own mistake
                    header("location: ../LoginPage.php?error=stmtfailed");
                    exit();
                }
                mysqli_stmt_bind_param($stmt, "s",$usn);//This actually bounds the statement for safety
                mysqli_stmt_execute($stmt);
        
                $retultData = mysqli_stmt_get_result($stmt);//This actually gets the data
        
                if($row =  mysqli_fetch_assoc($retultData))
                {
                    //If there is data inside of the 
                    return $row;
                } 
                else{
                    
                    //This would not worl so I guess we just send it to bad 
                    return false;
                }
                mysqli_stmt_close($stmt);
    }


   
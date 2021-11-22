<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="MyStyle.css">
   
    <!--Boostrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Login Page</title>
</head>
<body>
    <!--Header -->
  <div class="header">
     <h5>Login Page</h5>
    </div>  

  <!--Loging Page-->
  <form action="includes/login.php" method="POST"> 
  <div class="container-fuild">
      <div class ="top-buffer d-grid gap-3">
        <div class="mx-auto">
            <div class="card"> 
                <img src="Img/viperWaifu.png" class="card-img-top">
                <div class="card-body">
                 
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="username" placeholder="User-Example">
                    <label>Username</label>
                  </div>
                  <div class="form-floating">
                    <input type="password" class="form-control" name="password" placeholder="Password">
                    <label>Password</label>
                  </div>
                  <br></br>
                  <div class="text-center"><button class="btn btn-success" type="submit" name="submit">Submit</button></div>
                  
                  <?php
                  if(isset($_GET["error"]))//Check for errors
                  {
                    if($_GET["error"]== "wronguser")
                    {
                      echo "<p>Wrong username! </p>";
                    } else if($_GET["error"]== "wrongpass")
                    {
                      echo "<p>Wrong password! </p>";
                    } else if($_GET["error"]== "emptyinput")
                    {
                      echo "<p>Fill in all the info! </p>";
                    } else if($_GET["error"]== "notLogged")
                    {
                      echo "<p>Please log in to access the page! </p>";
                    }
                  }
                  ?>
                </div>
              </div>
          </div>
        </div>
  </div>

  </form>

  <!--Footer--> 
  <div class ="footer">
      <p> By Alvaro Gonzalez</p>
  </div>
    <!--Boostrap JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>
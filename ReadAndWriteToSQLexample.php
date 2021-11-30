  <!--Little tests to learn-->
  <!--Selecting Data-->
  <?php
    $sql = "SELECT * FROM logins;";//This is just the SQL code
    $result = mysqli_query($conn, $sql);
    $resultsCheck = mysqli_num_rows($result); //To check if it actually got a result

    if($resultsCheck >0)
    {
      while($row = mysqli_fetch_assoc($result)) //$row becomes and array with all the data
      {
        echo ($row['user']) . "<br>";
      }
    } else 
    {
      echo ("Data Base could not be reached :(");
    }

  ?>

  <!--Writting Data from a form-->
  <?php
    include_once 'ConectSQL.php';//To conect first
        //Simple way to secure the data sent to the data base
        $user = mysqli_real_escape_string($conn, $_POST['username']);
        $pass = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['username']);
    
      $sql = "insert into logins (user, password, email) VALUES ($user, $pass, $email);";//This is just the SQL code
      mysqli_query($conn, $sql);

      header("Location: ../Index.php?signup=sucess");//This goes back and sends the user to another page
  ?>
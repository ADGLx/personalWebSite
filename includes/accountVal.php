<?php
  /**This is just to make sure the user is logged, if its not its gonna be sent to the login page */
  if(!isset($_SESSION["userUsername"]))
  {
      header("Location: ../LoginPage.php?error=notLogged");
      die();
  }  
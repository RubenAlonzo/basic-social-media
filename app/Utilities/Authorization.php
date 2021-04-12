<?php

session_start();

class Authorization{

  public static function Authorize($depth = 2){
    $directoryUp = '';

    for ($i=0; $i < $depth ; $i++) { 
      $directoryUp .= '../';
    }

    if (!$_SESSION['auth']) {
      $_SESSION['loginMessage'] = ['You must sign in to access this resource', 'warning'];
      header("location: " . $directoryUp . 'public/views/login.php');
    }
  }

  public static function CheckAuthStatus(){
    return $_SESSION['auth'] ? true : false;
  }
}

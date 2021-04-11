<?php

session_start();
class Authorization{
  public static function Authorize($isRoot = false){
    $directoryUp = ($isRoot) ? '../' : "../../../";
    if (!$_SESSION['auth']) {
      $_SESSION['loginMessage'] = ['You must sign in to access this resource', 'warning'];
      header("location: basic-social-media/{$directoryUp}public/views/login.php");
    }
  }

  public static function CheckAuthStatus(){
    return $_SESSION['auth'] ? true : false;
  }
}

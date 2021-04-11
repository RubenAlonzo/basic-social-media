<?php
require_once __DIR__ . '/../../services/models/UserModelService.php';
require_once __DIR__ . '/../../Utilities/Utils.php';
require_once __DIR__ . '/../../database/Config.php';

session_start();

if(trim($_POST['userName']) && trim($_POST['password'])){

  $userModelService = new UserModelService();
   
  $user = $userModelService->TryGetByUsername($_POST['userName']);

  if ($user && $user->password == trim($_POST['password'])) {
    if($user->email_confirmed){
      $_SESSION['auth'] = $user;
      header('Location: ../../../public/views/home.php');
    }
    else{
      $_SESSION['loginMessage'] = ['Please confirm your email account before login', 'warning'];
      header('Location: ../../../public/views/login.php');  
    }
  }
  else{
    $_SESSION['loginMessage'] = ['Invalid login attempt', 'danger'];
    header('Location: ../../../public/views/login.php');
  }
}
<?php
require_once __DIR__ . '/../../services/models/UserModelService.php';
require_once __DIR__ . '/../../services/MailService.php';

session_start();

if(isset($_POST['username']) && trim($_POST['username'])){

  $username = trim($_POST['username']);
  $userModelService = new UserModelService();
  $user = $userModelService->TryGetByUsername($username);

  if(!$user){
    $_SESSION['loginMessage'] = ['The username does not exists', 'warning'];
  }
  else{

    $result = $userModelService->ResetPassword($username, $user->email);
    
    if($result)
    $_SESSION['loginMessage'] = ['Check you mailbox to continue', 'info'];
    else
    $_SESSION['loginMessage'] = ['Password reset failed', 'danger'];
  }
}
header('Location: ../../../public/views/login.php');

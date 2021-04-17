<?php
require_once __DIR__ . '/../../services/models/UserModelService.php';

session_start();

if(trim($_GET['username']) && trim($_GET['hash'])){

  $username = trim($_GET['username']);
  $hash = trim($_GET['hash']);

  $userModelService = new UserModelService();
  $result = $userModelService->ConfirmEmail($username, $hash);

  if($result)
    $_SESSION['loginMessage'] = ['Account confirmed successfully!', 'success'];
  else
    $_SESSION['loginMessage'] = ['Account confirmation failed', 'danger'];
  
}
header('Location: ../../../public/views/login.php');

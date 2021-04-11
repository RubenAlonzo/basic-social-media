<?php
require_once __DIR__ . '/../../services/models/UserModelService.php';
require_once __DIR__ . '/../../Utilities/Utils.php';
require_once __DIR__ . '/../../database/Config.php';

session_start();

if(trim($_POST['firstName']) 
&& trim($_POST['lastName'])
&& trim($_POST['phone'])
&& $_FILES['profilePic']
&& trim($_POST['email'])
&& trim($_POST['userName'])
&& trim($_POST['password'])
&& trim($_POST['confirmPassword'])
){
  $user = new stdClass();

  $user->FirstName = trim($_POST['firstName']);
  $user->LastName = trim($_POST['lastName']);
  $user->Phone = trim($_POST['phone']);
  $user->Email = trim($_POST['email']);
  $user->Username = trim($_POST['userName']);
  $user->Password = trim($_POST['password']); // TODO: Encrypt password
  $user->IsEmailConfirmed = false;
  
  // Check if password fields are the same
  if ($user->Password != trim($_POST['confirmPassword'])) {
    $_SESSION['registerMessage'] = ['Passwords not matching, please confirm your password', 'danger'];
    header('Location: ../../../public/views/register.php');
  }
  else{
    $userModelService = new UserModelService();
   
    // Check if username already exists
    $isUsernameValid = $userModelService->TryGetByUsername($user->Username) ? false : true; 
    if(!$isUsernameValid){
      $_SESSION['registerMessage'] = ['The username is already taken', 'danger'];
      header('Location: ../../../public/views/register.php');
    }
    else{
      // If inputs are valid and username is new, try to save the data
      $profileName = Utils::TryUploadImage($user->Username, $_FILES['profilePic'], IMG_DATA_PATH);
      $user->ProfilePic = $profileName ? $profileName : 'default.png';
      $result = $userModelService->Create($user);
      if($result){
        $_SESSION['loginMessage'] = ['Account created successfully!', 'success'];
        header('Location: ../../../public/views/login.php');
      }
      else{
        // If it gets here, something went wrong while inserting the data
        $_SESSION['registerMessage'] = ['Please make sure all fields are vaild', 'danger'];
        header('Location: ../../../public/views/register.php');
      }
    }
  }
}



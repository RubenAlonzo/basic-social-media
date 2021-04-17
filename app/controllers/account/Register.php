<?php
require_once __DIR__ . '/../../services/models/UserModelService.php';
require_once __DIR__ . '/../../services/MailService.php';
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

  $FirstName = trim($_POST['firstName']);
  $LastName = trim($_POST['lastName']);
  $Phone = trim($_POST['phone']);
  $Email = trim($_POST['email']);
  $Username = trim($_POST['userName']);
  $Password = trim($_POST['password']); // TODO: Encrypt password
  $IsEmailConfirmed = false;
  
  // Check if password fields are the same
  if ($Password != trim($_POST['confirmPassword'])) {
    $_SESSION['registerMessage'] = ['Passwords not matching, please confirm your password', 'danger'];
    header('Location: ../../../public/views/register.php');
  }
  else{
    $userModelService = new UserModelService();
   
    // Check if username already exists
    $isUsernameValid = $userModelService->TryGetByUsername($Username) ? false : true; 
    if(!$isUsernameValid){
      $_SESSION['registerMessage'] = ['The username is already taken', 'danger'];
      header('Location: ../../../public/views/register.php');
    }
    else{
      // If inputs are valid and username is new, try to save the data
      $profileName = Utils::TryUploadImage($_FILES['profilePic'], IMG_PROFILE_PATH, $Username);
      $profileName = $profileName ? $profileName : 'default.png';
      $hash = md5(rand(0,1000));
      $result = $userModelService->Create($FirstName, $LastName, $Phone, $Email, $Username, $Password,$profileName, $IsEmailConfirmed, $hash);
      if($result){
        $mailer = new MailService();
        $mailer->SendMail($Email, 'Email confirmation', "<p>Follow this link to confirm your account <a href='http://localhost/basic-social-media/app/controllers/account/ConfirmEmail.php?username={$Username}&hash={$hash}'>Link</a></p>");
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



<?php
require_once __DIR__ . '/../../services/models/FriendModelService.php';
require_once __DIR__ . '/../../services/models/UserModelService.php';
require_once __DIR__ . '/../../Utilities/Authorization.php';

Authorization::Authorize(3);

if(isset($_POST['username']) && trim($_POST['username'])){
  
  $idUser = $_SESSION['auth']->id_user;
  $username = trim($_POST['username']);

  $userService = new UserModelService();
  $user = $userService->TryGetByUsername($username); 

  if($user && $user->email_confirmed){
    $friendService = new FriendModelService();
    $areRelated = $friendService->HaveRelation($idUser, $user->id_user);
    if($areRelated === false){
      $result = $friendService->SendFriendRequest($idUser, $user->id_user);
      $_SESSION['homeMessage'] = ['Request sent!', 'info'];
    }
    else{
      $_SESSION['homeMessage'] = [$areRelated[1], 'warning'];
    }
  }
  else{
    // If it gets here, something went wrong while inserting the data
    $_SESSION['homeMessage'] = ['The user does not exists', 'warning'];
  }
}
header('Location: ../../../public/views/friends.php');

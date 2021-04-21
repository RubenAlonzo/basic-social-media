<?php
require_once __DIR__ . '/../../services/models/FriendModelService.php';
require_once __DIR__ . '/../../services/models/UserModelService.php';
require_once __DIR__ . '/../../Utilities/Authorization.php';

Authorization::Authorize(3);

if(isset($_GET['id']) && trim($_GET['id'])){
  
  $idUser = $_SESSION['auth']->id_user;
  $id = trim($_GET['id']);

  $userService = new UserModelService();
  $user = $userService->TryGetById($id); 

  if($user && $user->email_confirmed){
    $friendService = new FriendModelService();
    $friendService->DeclineRequest($idUser, $user->id_user);
    $_SESSION['homeMessage'] = ['Friend removed', 'info'];
  }
  else{
    // If it gets here, something went wrong while inserting the data
    $_SESSION['homeMessage'] = ['The user does not exists', 'warning'];
  }
}
header('Location: ../../../public/views/friends.php');

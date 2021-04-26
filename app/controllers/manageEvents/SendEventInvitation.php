<?php
require_once __DIR__ . '/../../services/models/EventModelService.php';
require_once __DIR__ . '/../../services/models/FriendModelService.php';
require_once __DIR__ . '/../../services/models/UserModelService.php';
require_once __DIR__ . '/../../Utilities/Authorization.php';

Authorization::Authorize(3);

if(isset($_POST['username']) 
&& trim($_POST['username']) 
&& isset($_POST['idEvent']) 
&& trim($_POST['idEvent'])){
  
  $idUser = $_SESSION['auth']->id_user;
  $username = trim($_POST['username']);
  $idEvent = trim($_POST['idEvent']);

  $userService = new UserModelService();
  $user = $userService->TryGetByUsername($username); 

  if($user && $user->email_confirmed){
    $friendService = new FriendModelService();
    $areFriends = $friendService->AreFriends($idUser, $user->id_user);
    if($areFriends == false){
      $_SESSION['manageEventMessage'] = ['Friend not found', 'warning'];
    }
    else{
      $eventService = new EventModelService();

      $userInvitations = $eventService->GetEventInvitations($user->id_user);

      $isInvited = false;
      foreach($userInvitations as $invitation){
        if($invitation->id_event == $idEvent){
          $isInvited = true;
          break;
        }
      }

      if(!$isInvited){
        $result = $eventService->SendEventInvitation($idEvent, $user->id_user);

        if($result)
        $_SESSION['manageEventMessage'] = ['Invitation sent', 'info'];
        
        else
        $_SESSION['manageEventMessage'] = ['There was an error with your request', 'danger'];
      }
      else{
        $_SESSION['manageEventMessage'] = ['You already invited this friend', 'warning'];
      }
    }
  }
  else{
    $_SESSION['manageEventMessage'] = ['Friend not found', 'warning'];
  }
}
header('Location: ../../../public/views/ManageEvents.php?id=' . $_POST['idEvent']);

<?php
require_once __DIR__ . '/../../services/models/FriendModelService.php';
require_once __DIR__ . '/../../services/models/UserModelService.php';
require_once __DIR__ . '/../../Utilities/Authorization.php';

Authorization::Authorize(3);

if(isset($_POST['id']) 
&& trim($_POST['id']) 
&& isset($_POST['response']) 
&& trim($_POST['response'])){
  
  $currentUserId = $_SESSION['auth']->id_user;
  $SenderId = trim($_POST['id']);
  $response = trim($_POST['response']);

  $userService = new UserModelService();
  $user = $userService->TryGetById($SenderId); 

  if($user && $user->email_confirmed){
    $friendService = new FriendModelService();
    switch ($response) {
      case 'accept':
          $friendService->AcceptRequest($SenderId, $currentUserId);
          $_SESSION['notificationMessage'] = ["Now, you and {$user->first_name} {$user->last_name} are friends!", 'success'];
        break;
        case 'decline':
          $friendService->DeclineRequest($SenderId, $currentUserId);
          $_SESSION['notificationMessage'] = ["Request declined", 'info'];
        break;
    }
  }
  else{
    // If it gets here, something went wrong while inserting the data
    $_SESSION['notificationMessage'] = ['The user does not exists', 'warning'];
  }
}
header('Location: ../../../public/views/notifications.php');

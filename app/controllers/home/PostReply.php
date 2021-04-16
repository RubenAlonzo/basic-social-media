<?php
require_once __DIR__ . '/../../services/models/replyModelService.php';
require_once __DIR__ . '/../../Utilities/Utils.php';
require_once __DIR__ . '/../../database/Config.php';
require_once __DIR__ . '/../../Utilities/Authorization.php';

Authorization::Authorize(3);

if((trim($_POST['textreply']) || $_FILES['photoreply']['error'] != 4)
&& trim($_POST['idpost']) && trim($_POST['repliedto']) && trim($_POST['repliedtype'])){
  
  $reply = new stdClass();
  $reply->ImageContent= null;
  $reply->TextContent = trim($_POST['textreply']);
  $reply->IdUser = $_SESSION['auth']->id_user;
  $reply->IdPost = trim($_POST['idpost']);
  $reply->ParentReply = isset($_POST['repliedto']) ? $_POST['repliedto'] : null;

  $img = $_FILES['photoreply'];
  $isReplyValid = true;

  if(isset($img) && $img['error'] != 4){
    $reply->ImageContent= Utils::TryUploadImage($img, IMG_POST_PATH);
    if($reply->ImageContent== null){
      $isReplyValid = false;
    }
  } 
      
  $replyModelService = new ReplyModelService();
  $result = $isReplyValid ? $replyModelService->Create($reply) : false;

  if($result){
    $_SESSION['homeMessage'] = ['Reply added!', 'info'];
  }
  else{
    if ($reply->ImageContent == null) {
      // An unsopported image was trying to be saved so, reply is invalid due to it
      $_SESSION['homeMessage'] = ['Unsupported image file', 'warning'];
    }
    else{
      // If it gets here, something went wrong while inserting the data
      $_SESSION['homeMessage'] = ['There was an error with your request', 'danger'];
    }
  }
}
header('Location: ../../../public/views/home.php');

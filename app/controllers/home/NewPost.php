<?php
require_once __DIR__ . '/../../services/models/PostModelService.php';
require_once __DIR__ . '/../../Utilities/Utils.php';
require_once __DIR__ . '/../../database/Config.php';
require_once __DIR__ . '/../../Utilities/Authorization.php';

Authorization::Authorize(3);

if(trim($_POST['textpost']) || $_FILES['photopost']){
  
  $img = $_FILES['photopost'];
  $text = trim($_POST['textpost']);
  $imageName = null;

  $post = new stdClass();
  $post->IdUser = $_SESSION['auth']->id_user;
  if($img) $imageName = Utils::TryUploadImage($_FILES['photopost'], IMG_POST_PATH);
   
  if(!$imageName){
    $_SESSION['homeMessage'] = ['Unsupported image file', 'warning'];
    header('Location: ../../../public/views/home.php');
  }
  else{
    $post->ImageContent = $imageName;
    if($text) $post->TextContent = $text;
    
    $postModelService = new PostModelService();
    $result = $postModelService->Create($post);
    
    if($result){
      $_SESSION['homeMessage'] = ['Post published!', 'info'];
      header('Location: ../../../public/views/home.php');
    }
    else{
      // If it gets here, something went wrong while inserting the data
      $_SESSION['homeMessage'] = ['There was an error with your request', 'danger'];
      header('Location: ../../../public/views/home.php');
    }
  }
}
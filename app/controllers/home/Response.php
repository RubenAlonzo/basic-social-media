<?php
require_once __DIR__ . '/../../services/models/ResponseModelService.php';
require_once __DIR__ . '/../../Utilities/Utils.php';
require_once __DIR__ . '/../../database/Config.php';
require_once __DIR__ . '/../../Utilities/Authorization.php';

Authorization::Authorize(3);

if((trim($_POST['textresponse']) || $_FILES['photoresponse']['error'] != 4)
&& isset($_POST['parentid']) 
&& trim($_POST['postid'])){
  
  // Data
  $img = $_FILES['photoresponse'];
  $text = trim($_POST['textresponse']);
  $parentId = $_POST['parentid'];
  $postId = $_POST['postid'];
  $userId =  $_SESSION['auth']->id_user;

  $imageName = null;
  $proceedCreation = true;
  $result = false;

  if(isset($img) && $img['error'] != 4){
    $imageName = Utils::TryUploadImage($_FILES['photoresponse'], IMG_POST_PATH);
    if($imageName == null) $proceedCreation = false; 
  } 

  if(!$imageName && !$text) $proceedCreation = false;

  if($proceedCreation){
    $creationService = new ResponseModelService();
    $result = $creationService->Create($userId, $postId, $parentId, $text, $imageName);
  }
  
  if($result){
    $_SESSION['homeMessage'] = ['Publish succeded!', 'info'];
  }
  else{
    if ($imageName == null) {
      $_SESSION['homeMessage'] = ['Unsupported image file', 'warning'];
    }
    else{
      // If it gets here, something went wrong while inserting the data
      $_SESSION['homeMessage'] = ['There was an error with your request', 'danger'];
    }
  }
}
else{
  $_SESSION['homeMessage'] = ['No content', 'warning'];
}
if(isset($_GET['page'])) 
  header("Location: ../../../public/views/". $_GET['page'] . ".php");
else
  header('Location: ../../../public/views/home.php');

<?php
require_once __DIR__ . '/../../services/models/ResponseModelService.php';
require_once __DIR__ . '/../../services/models/PostModelService.php';
require_once __DIR__ . '/../../Utilities/Utils.php';
require_once __DIR__ . '/../../database/Config.php';
require_once __DIR__ . '/../../Utilities/Authorization.php';

Authorization::Authorize(3);

if((isset($_POST['text']) || $_FILES['photo']['error'] != 4)
&& isset($_POST['type']) 
&& isset($_POST['id']) 
&& isset($_POST['imageName'])){
  
  // Data
  $id = $_POST['id'];
  $newImg = $_FILES['photo'];
  $imageName = $_POST['imageName'];
  $text = trim($_POST['text']);
  $type = $_POST['type'];

  $service = null;
  switch ($type) {
    case 'post':
      $service = new PostModelService();
      break;
    case 'reply':
      $service = new ResponseModelService();
      break;
  }

  if($service != null){
    $result = $service->UpdateContent($id, $text, $newImg, $imageName);
    if($result){
      $_SESSION['editMessage'] = ['Edit succeded!', 'info'];
    }
    else{
      // If it gets here, something went wrong while inserting the data
      $_SESSION['editMessage'] = ['There was an error with your request', 'danger'];
    }
  }
}
else{
  $_SESSION['editMessage'] = ['No content', 'warning'];
}
header("Location: ../../../public/views/edit.php?id=".$_POST['id']."&type=".$_POST['type']);
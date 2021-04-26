<?php
require_once __DIR__ . '/../../services/models/EventModelService.php';
require_once __DIR__ . '/../../Utilities/Authorization.php';

Authorization::Authorize(3);

if(isset($_GET['id']) && trim($_GET['id'])){
  
  $id = trim($_GET['id']);
  $eventService = new EventModelService();
  $result = $eventService->DeleteEvent($id);

  if($result){
    $_SESSION['myEventMessage'] = ['Event removed', 'info'];
  }
  else{
    $_SESSION['myEventMessage'] = ['There was an error with your request', 'danger'];
  }
}
header('Location: ../../../public/views/MyEvents.php');
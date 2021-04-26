<?php
require_once __DIR__ . '/../../services/models/EventModelService.php';
require_once __DIR__ . '/../../Utilities/Authorization.php';

Authorization::Authorize(3);
$idEvent = '';
if(isset($_GET['id']) && trim($_GET['id'])){
  
  $id = trim($_GET['id']);
  $eventService = new EventModelService();
  $idEvent = $eventService->GetEventFromInvitation($id)->id_event;
  $result = $eventService->DeleteEventInvitation($id);

  if($result){
    $_SESSION['manageEventMessage'] = ['Invitation removed', 'info'];
  }
  else{
    $_SESSION['manageEventMessage'] = ['There was an error with your request', 'danger'];
  }
}
header('Location: ../../../public/views/ManageEvents.php?id=' . $idEvent);
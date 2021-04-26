<?php
require_once __DIR__ . '/../../services/models/EventModelService.php';
require_once __DIR__ . '/../../Utilities/Authorization.php';

Authorization::Authorize(3);

if(isset($_POST['idInvitation']) 
&& trim($_POST['idInvitation'])){
  
  $idInvitation = trim($_POST['idInvitation']);
  $radioName = 'radio_' . $idInvitation;

  if(isset($_POST[$radioName]) 
  && trim($_POST[$radioName])){

    $response = trim($_POST[$radioName]);

    $eventService = new EventModelService();
    $result = $eventService->ResponseEventInvitation($idInvitation, $response);

    if($result){
      $_SESSION['eventInvitationMessage'] = ['Response sent', 'info'];
    }
    else{
      $_SESSION['eventInvitationMessage'] = ['There was an error with your request', 'danger'];
    }
  }
}
header('Location: ../../../public/views/EventInvitations.php');
<?php
require_once __DIR__ . '/../../services/models/EventModelService.php';
require_once __DIR__ . '/../../Utilities/Authorization.php';

Authorization::Authorize(3);

if(isset($_POST['title']) && isset($_POST['place']) && isset($_POST['date'])){
  
  $idUser = $_SESSION['auth']->id_user;
  $title = trim($_POST['title']);
  $place = trim($_POST['place']);
  $date = trim($_POST['date']);

  $isDateValid = Utils::IsDateAfterNow($date);

  if($title && $place && $isDateValid){
    $eventService = new EventModelService();
    $result = $eventService->Create($idUser, $title, $place, $date);

    if($result){
      $_SESSION['myEventMessage'] = ['Event created successfully', 'success'];
    }
    else{
      $_SESSION['myEventMessage'] = ['There was an error with your request', 'danger'];
    }
  }
  else{
    // If it gets here, something went wrong while inserting the data
    $_SESSION['myEventMessage'] = ['Make sure all the fields are valid', 'warning'];
  }
}
header('Location: ../../../public/views/MyEvents.php');

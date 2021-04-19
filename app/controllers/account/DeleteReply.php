<?php
require_once __DIR__ . '/../../services/models/ResponseModelService.php';

session_start();

if(isset($_GET['id']) && trim($_GET['id'])){

  $id = trim($_GET['id']);

  $responseModelService = new ResponseModelService();
  $result = $responseModelService->DeleteReply($id);

  if($result)
    $_SESSION['homeMessage'] = ['Reply deleted successfully!', 'success'];
  else
    $_SESSION['homeMessage'] = ['There was an error with your request', 'danger'];
  
}
header('Location: ../../../public/views/home.php');
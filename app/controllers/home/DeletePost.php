<?php
require_once __DIR__ . '/../../services/models/PostModelService.php';

session_start();

if(isset($_GET['id']) && trim($_GET['id']) && isset($_GET['page']) ){

  $postId = trim($_GET['id']);

  $postModelService = new PostModelService();
  $result = $postModelService->DeletePost($postId);

  if($result)
    $_SESSION['homeMessage'] = ['Post deleted successfully!', 'success'];
  else
    $_SESSION['homeMessage'] = ['There was an error with your request', 'danger'];
  
}
header("Location: ../../../public/views/". $_GET['page'] . ".php");
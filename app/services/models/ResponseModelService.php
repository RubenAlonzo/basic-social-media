<?php
require_once __DIR__ . '/abstract/ModelServiceBase.php';

class ResponseModelService extends ModelServiceBase{
  public $IdUser = 'id_user';
  public $IdPost = 'id_post';
  public $IdComment = 'id_comment';
  public $IdReply = 'id_reply';
  public $TextContent = 'text_content';
  public $ImageContent = 'image_content';
  public $Timestamp = 'time_stamp';

  public function Create($userId, $parentId, $text, $imageName, $responseType){
    
    $result = false;

    if($responseType == 'comment' || $responseType == 'reply'){
      
      $parentCol = ($responseType == 'comment') ? 'id_post' : 'id_comment';
     
      $query = $this->db->prepare(
        "INSERT INTO  {$responseType} ({$parentCol}, id_user, text_content, image_content) 
        values (?, ?, ?, ?)") or trigger_error($query->error, E_USER_WARNING);
      $query->bind_param("iiss", $parentId, $userId, $text, $imageName);
      $result = $query->execute() or trigger_error($query->error, E_USER_WARNING);
      $query->close();
    }

    return $result;
  }

  public function GetList($parentId, $responseType){

    $postList = array();
    if($responseType == 'comment' || $responseType == 'reply'){
      
      $parentCol = ($responseType == 'comment') ? 'id_post' : 'id_comment';
      $query = $this->db->prepare(
        "SELECT * FROM  {$responseType} WHERE {$parentCol} = ? ORDER BY time_stamp ASC") or trigger_error($query->error, E_USER_WARNING);
      $query->bind_param("i", $parentId);
      $query->execute() or trigger_error($query->error, E_USER_WARNING);
      $result = $query->get_result();
      $query->close();
      
      if($result->num_rows === 0) return null;
      
      while ($row = $result->fetch_object()) {
        array_push($postList, $row);
      }
    }
    return $postList;
  }

  public function GetChildReply($childId){

    $postList = array();

    $query = $this->db->prepare(
      "SELECT * FROM  reply WHERE id_reply = ? ORDER BY time_stamp ASC") or trigger_error($query->error, E_USER_WARNING);
    $query->bind_param("i", $childId);
    $query->execute() or trigger_error($query->error, E_USER_WARNING);
    $result = $query->get_result();
    $query->close();
    
    if($result->num_rows === 0) return null;
    
    while ($row = $result->fetch_object()) {
      array_push($postList, $row);
    }
    
    return $postList;
  }
}
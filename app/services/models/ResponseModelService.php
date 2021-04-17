<?php
require_once __DIR__ . '/abstract/ModelServiceBase.php';

class ResponseModelService extends ModelServiceBase{

  public function Create($userId, $postId, $parentId, $text, $imageName){

    $result = false;

    $query = $this->db->prepare(
      "INSERT INTO  reply (id_user, id_post, id_parent, text_content, image_content) 
      values (?, ?, ?, ?, ?)") or trigger_error($query->error, E_USER_WARNING);

    $query->bind_param("iiiss", $userId, $postId, $parentId, $text, $imageName);

    $result = $query->execute() or trigger_error($query->error, E_USER_WARNING);
    $query->close();

    return $result;
  }

  public function GetReplies($postId, $parentId){
    
    $resulList = array();

    $query = $this->db->prepare(
      "SELECT * FROM  reply WHERE id_post = ? AND id_parent = ? ORDER BY time_stamp ASC") 
      or trigger_error($query->error, E_USER_WARNING);

    $query->bind_param("ii", $postId, $parentId);

    $query->execute() or trigger_error($query->error, E_USER_WARNING);
    $result = $query->get_result();
    $query->close();
    
    if($result->num_rows === 0) return null;
    
    while ($row = $result->fetch_object()) {
      array_push($resulList, $row);
    }
    
    return $resulList;
  }
}
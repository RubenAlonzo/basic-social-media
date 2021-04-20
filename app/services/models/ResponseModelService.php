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

  public function UpdateContent($id, $newText, $newImage, $previousImageName){
    $result = $this->UpdateFieldById('reply', 'text_content', $newText, 'id_reply', $id);
    if($newImage && $newImage['error'] != 4 && $result){
      Utils::DeleteFile(IMG_POST_PATH . '/' . $previousImageName);
      $newImageName = Utils::TryUploadImage($newImage, IMG_POST_PATH);
      $result = $this->UpdateFieldById('reply', 'image_content', $newImageName, 'id_reply', $id);
    } 
    return $result;
  }

  public function TryGetValuesById($replyId){
    $result =  $this->TryGetListById('*', 'reply', 'id_reply', $replyId);
    return (isset($result[0])) ? $result[0] : null; 
  }

  public function DeleteReply($replyId){
    $childs = $this->TryGetListById('*', 'reply', 'id_parent', $replyId);    
    foreach($childs as $child ){
      $this->DeleteReply($child->id_reply);
    }
    $this->RemoveImage($replyId, 'reply', 'id_reply');
    return $this->DeleteById('reply', 'id_reply', $replyId);
  }
}
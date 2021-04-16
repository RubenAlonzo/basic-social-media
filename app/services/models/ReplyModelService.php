<?php
require_once __DIR__ . '/abstract/ModelServiceBase.php';
require_once __DIR__ . '/UserModelService.php';

class ReplyModelService extends ModelServiceBase{
  public $IdReply = 'id_reply';
  public $IdPost = 'id_post';
  public $IdUser = 'id_user';
  public $ParentReply = 'parent_reply';
  public $TextContent = 'text_content';
  public $ImageContent = 'image_content';
  public $Timestamp = 'time_stamp';

  public function Create($entity){
    $query = $this->db->prepare(
      "INSERT INTO  reply ($this->IdPost, $this->IdUser, $this->ParentReply, $this->TextContent, $this->ImageContent) 
      VALUES (?, ?, ?, ?, ?)") or trigger_error($query->error, E_USER_WARNING);
    $query->bind_param("iiiss", $entity->IdPost, $entity->IdUser, $entity->ParentReply, $entity->TextContent, $entity->ImageContent);
    $result = $query->execute() or trigger_error($query->error, E_USER_WARNING);
    $query->close();
    return $result;
  }

  public function GetListByPostId($id){
    $query = $this->db->prepare(
      "SELECT * FROM  reply WHERE $this->IdPost = ? ORDER BY $this->Timestamp DESC") or trigger_error($query->error, E_USER_WARNING);
    $query->bind_param("i", $id);
    $query->execute() or trigger_error($query->error, E_USER_WARNING);
    $result = $query->get_result();
    $query->close();

    if($result->num_rows === 0) return null;
    
    $postList = array();
    while ($row = $result->fetch_object()) {
      array_push($postList, $row);
    }
    return $postList;
  }

  public function GetPostReplies($postId){
    $query = $this->db->prepare(
      "SELECT * FROM reply WHERE id_post = ? ORDER BY $this->Timestamp DESC") or trigger_error($query->error, E_USER_WARNING);
    $query->bind_param("i", $postId);
    $query->execute() or trigger_error($query->error, E_USER_WARNING);
    $result = $query->get_result();
    $query->close();

    if($result->num_rows === 0) return null;
    
    $replyList = array();
    while ($row = $result->fetch_object()) {
      array_push($replyList, $row);
    }

    $postReplies = [];
    $userModelService = new UserModelService();
    $tempReplyList = $replyList;
    foreach($replyList as $reply){
      
      $reply->username = $userModelService->TryGetById($reply->id_user);
      $replyParent = $reply->parent_reply;
      $parent = null;
      while($replyParent > 0){
        foreach($tempReplyList as $replyB){
          if($replyB->id_reply == $reply->parent_reply){
            $parent = $replyB;
            break;
          }
        }
        $parent->childs = $reply;
        $replyParent = $parent->parent_reply;
        $parent = null;
      }

    }


  }
}

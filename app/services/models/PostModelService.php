<?php
require_once __DIR__ . '/abstract/ModelServiceBase.php';
require_once __DIR__ . '/FriendModelService.php';
require_once __DIR__ . '../../../Utilities/Utils.php';
require_once __DIR__ . '../../../database/Config.php';

class PostModelService extends ModelServiceBase{

  public function Create($idUser, $text, $imageName){

    $query = $this->db->prepare(
      "INSERT INTO  post (id_user, text_content, image_content) values (?, ?, ?)") 
      or trigger_error($query->error, E_USER_WARNING);

    $query->bind_param("iss", $idUser, $text, $imageName);
    $result = $query->execute() or trigger_error($query->error, E_USER_WARNING);
    $query->close();

    return $result;
  }

  public function GetListByUserId($id){

    $query = $this->db->prepare(
      "SELECT * FROM  post WHERE id_user = ? ORDER BY time_stamp DESC") 
      or trigger_error($query->error, E_USER_WARNING);

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

  public function GetListFromFriendsByUserId($id){

    $friendService = new FriendModelService();
    $friendIds = $friendService->GetFriendsIdByUserId($id);
    $conditions = $this->ComposeCondition($friendIds, 'post.id_user', '=', 'or');

    if(!$conditions) return array();

    $query = $this->db->prepare(
      "SELECT * FROM user INNER JOIN post ON user.id_user = post.id_user
      WHERE ({$conditions}) ORDER BY post.time_stamp DESC;") 
      or trigger_error($query->error, E_USER_WARNING);

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

  private function ComposeCondition($idList, $field, $condition, $conjunction){
    $conditions = '';
    foreach($idList as $id){
      if(end($idList) != $id)
        $conditions .= "{$field} {$condition} {$id} {$conjunction} ";
      else
        $conditions .= "{$field} {$condition} {$id}";
    }

    return$conditions;
  }

  public function TryGetValuesById($postId){
    $result =  $this->TryGetListById('*', 'post', 'id_post', $postId);
    return (isset($result[0])) ? $result[0] : null; 
  }

  public function UpdateContent($id, $newText, $newImage, $previousImageName){
    $result = $this->UpdateFieldById('post', 'text_content', $newText, 'id_post', $id);
    if($newImage && $newImage['error'] != 4 && $result){
      Utils::DeleteFile(IMG_POST_PATH . '/' . $previousImageName);
      $newImageName = Utils::TryUploadImage($newImage, IMG_POST_PATH);
      $result = $this->UpdateFieldById('post', 'image_content', $newImageName, 'id_post', $id);
    } 
    return $result;
  }

  public function DeletePost($postId){

    $this->RemoveImage($postId, 'post', 'id_post');

    $query = $this->db->prepare(
      "DELETE FROM post WHERE (id_post = ?)") 
      or trigger_error($query->error, E_USER_WARNING);

    $query->bind_param("i", $postId);
    $result = $query->execute() or trigger_error($query->error, E_USER_WARNING);
    $query->close();

    return $result;
  }



}

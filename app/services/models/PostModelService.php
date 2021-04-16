<?php
require_once __DIR__ . '/abstract/ModelServiceBase.php';

class PostModelService extends ModelServiceBase{
  public $IdPost = 'id_post';
  public $IdUser = 'id_user';
  public $TextContent = 'text_content';
  public $ImageContent = 'image_content';
  public $Timestamp = 'time_stamp';

  public function Create($entity){
    $query = $this->db->prepare(
      "INSERT INTO  post ($this->IdUser, $this->TextContent, 
      $this->ImageContent) values (?, ?, ?)") or trigger_error($query->error, E_USER_WARNING);
    $query->bind_param("iss", $entity->IdUser, $entity->TextContent, $entity->ImageContent);
    $result = $query->execute() or trigger_error($query->error, E_USER_WARNING);
    $query->close();
    return $result;
  }

  public function GetListByUserId($id){
    $query = $this->db->prepare(
      "SELECT * FROM  post WHERE $this->IdUser = ? ORDER BY $this->Timestamp DESC") or trigger_error($query->error, E_USER_WARNING);
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
}

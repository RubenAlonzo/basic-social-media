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
      "SELECT * FROM  post WHERE $this->IdUser = ? order by time_stamp") or trigger_error($query->error, E_USER_WARNING);
    $query->bind_param("i", $id);
    $query->execute() or trigger_error($query->error, E_USER_WARNING);
    $result = $query->get_result();
    $query->close();

    if($result->num_rows === 0) return null;
    
    $postList = array();
    while ($row = $result->fetch_array()) {

      $post = new stdClass();
      $post->id_post = $row[$this->IdPost];
      $post->id_user = $row[$this->IdUser];
      $post->text_content = $row[$this->TextContent];
      $post->image_content = $row[$this->ImageContent];
      $post->time_stamp = $row[$this->Timestamp];

      array_push($postList, $post);
    }
    return $postList;
  }
}

<?php
require_once __DIR__ . '/abstract/ModelServiceBase.php';

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
}

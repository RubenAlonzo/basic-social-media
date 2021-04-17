<?php
require_once __DIR__ . '/abstract/ModelServiceBase.php';

class FriendModelService extends ModelServiceBase{

  public function GetFriendsIdByUserId($id){

    $query = $this->db->prepare(
      "SELECT * FROM  friend WHERE (id_user_one = ? OR id_user_two = ?) AND status = 1") 
      or trigger_error($query->error, E_USER_WARNING);

    $query->bind_param("ii", $id, $id);

    $query->execute() or trigger_error($query->error, E_USER_WARNING);
    $result = $query->get_result();
    $query->close();

    if($result->num_rows === 0) return null;
    
    $friendIdList = array();
    while ($row = $result->fetch_array()) {
      $friendId = ($row['id_user_one'] == $id) ? $row['id_user_two'] : $row['id_user_one'];
      array_push($friendIdList, $friendId);
    }
    return $friendIdList;
  }
}
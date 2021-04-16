<?php
require_once __DIR__ . '/abstract/ModelServiceBase.php';

class FriendModelService extends ModelServiceBase{
  public $UserOne = 'id_user_one';
  public $UserTwo = 'id_user_two';
  public $Status = 'status';
  public $LastUserAction = 'id_last_user_action';


  public function GetFriendsIdByUserId($id){
    $query = $this->db->prepare(
      "SELECT * FROM  friend 
      WHERE ($this->UserOne = ? OR $this->UserTwo = ?) 
      AND $this->Status = 1") or trigger_error($query->error, E_USER_WARNING);
    $query->bind_param("ii", $id, $id);
    $query->execute() or trigger_error($query->error, E_USER_WARNING);
    $result = $query->get_result();
    $query->close();

    if($result->num_rows === 0) return null;
    
    $friendIdList = array();
    while ($row = $result->fetch_array()) {
      $friendId = ($row[$this->UserOne] == $id) ? $row[$this->UserTwo] : $row[$this->UserOne];
      array_push($friendIdList, $friendId);
    }
    return $friendIdList;
  }
}
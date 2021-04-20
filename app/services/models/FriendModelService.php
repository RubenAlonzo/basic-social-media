<?php
require_once __DIR__ . '/abstract/ModelServiceBase.php';
require_once __DIR__ . '/UserModelService.php';
require_once __DIR__ . '../../../Utilities/Utils.php';

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
  
  public function TryGetFriendsById($id){
    $friendIds = $this->GetFriendsIdByUserId($id);
    
    if(!$friendIds) return array();
    
    $friends = array();
    $userService = new UserModelService();
    
    foreach($friendIds as $id){
      $friend = $userService->TryGetById($id);
      if($friend) array_push($friends, $friend);
    }
    
    return $friends;
  }
  
    public function SendFriendRequest($sender, $receiver){
      $order = Utils::SortOrder($sender, $receiver);
      
      $query = $this->db->prepare(
        "INSERT INTO friend (id_user_one, id_user_two, status, id_last_user_action)
        VALUES (?, ?, 0, ?)") 
        or trigger_error($query->error, E_USER_WARNING);
  
      $query->bind_param("iii", $order[0], $order[1], $order[0]);
  
      $query->execute() or trigger_error($query->error, E_USER_WARNING);
      $result = $query->get_result();
      $query->close();
      return $result;
    }
}
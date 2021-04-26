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

    if($result->num_rows === 0) return array();
    
    $friendIdList = array();
    while ($row = $result->fetch_array()) {
      $friendId = ($row['id_user_one'] == $id) ? $row['id_user_two'] : $row['id_user_one'];
      array_push($friendIdList, $friendId);
    }
    return $friendIdList;
  }

  public function GetPendingRequestsIdByUserId($id){

    $query = $this->db->prepare(
      "SELECT * FROM  friend WHERE (id_user_one = ? OR id_user_two = ?) AND status = 0 AND id_last_user_action != ?") 
      or trigger_error($query->error, E_USER_WARNING);

    $query->bind_param("iii", $id, $id, $id);

    $query->execute() or trigger_error($query->error, E_USER_WARNING);
    $result = $query->get_result();
    $query->close();

    if($result->num_rows === 0) return array();
    
    $friendIdList = array();
    while ($row = $result->fetch_array()) {
      $friendId = ($row['id_user_one'] == $id) ? $row['id_user_two'] : $row['id_user_one'];
      array_push($friendIdList, $friendId);
    }

    return $friendIdList;
  }
  
  public function TryGetFriendsById($id, $pending = false){
    $friendIds = $pending ? $this->GetPendingRequestsIdByUserId($id) : $this->GetFriendsIdByUserId($id);
    
    if(!$friendIds) return array();
    
    $friends = array();
    $userService = new UserModelService();
    
    foreach($friendIds as $id){
      $friend = $userService->TryGetById($id);
      if($friend && $friend->email_confirmed) array_push($friends, $friend);
    }
    
    return $friends;
  }
  
  public function GetPendingRequests($id){
    return $this->TryGetFriendsById($id, true);
  }

  public function HaveRelation($senderId, $receiverId){

    if($senderId == $receiverId) return [true, 'You cannot send requests to yourself'];

    $friendList = $this->GetFriendsIdByUserId($senderId);
    $areFriends = array_search($receiverId, $friendList);
    if($areFriends !== false) return [true, 'You are friends'];
    
    $senderPendingRequestIds = $this->GetPendingRequestsIdByUserId($senderId);
    $senderHasRequest = array_search($receiverId, $senderPendingRequestIds);
    if($senderHasRequest !== false) return [true, 'You have a request from this user'];

    $receiverPendingRequestIds = $this->GetPendingRequestsIdByUserId($receiverId);
    $receiverHasRequest = array_search($senderId, $receiverPendingRequestIds);
    if($receiverHasRequest !== false) return [true, 'You already sent a request to this user'];

    // If it gets here, means there is no relation between this users
    return false;
  }

  public function AreFriends($currentUserId, $otherUserId){
    if($currentUserId == $otherUserId) return false;
    $friendList = $this->GetFriendsIdByUserId($currentUserId);
    $areFriends = array_search($otherUserId, $friendList);
    return ($areFriends === false) ?  false : true;
  } 


  public function SendFriendRequest($sender, $receiver){
    $order = Utils::SortOrder($sender, $receiver);
    
    $query = $this->db->prepare(
      "INSERT INTO friend (id_user_one, id_user_two, status, id_last_user_action)
      VALUES (?, ?, 0, ?)") 
      or trigger_error($query->error, E_USER_WARNING);

    $query->bind_param("iii", $order[0], $order[1], $sender);

    $query->execute() or trigger_error($query->error, E_USER_WARNING);
    $result = $query->get_result();
    $query->close();
    return $result;
  }

  public function AcceptRequest($sender, $receiver){
    $order = Utils::SortOrder($sender, $receiver);
    
    $query = $this->db->prepare(
      "UPDATE friend SET status = 1, id_last_user_action = ? WHERE (id_user_one = ? AND id_user_two = ?)") 
      or trigger_error($query->error, E_USER_WARNING);

    $query->bind_param("iii", $receiver, $order[0], $order[1]);

    $query->execute() or trigger_error($query->error, E_USER_WARNING);
    $result = $query->get_result();
    $query->close();
    return $result;
  }

  public function DeclineRequest($sender, $receiver){
    $order = Utils::SortOrder($sender, $receiver);
    
    $query = $this->db->prepare(
      "DELETE FROM friend WHERE (id_user_one = ? AND id_user_two = ?)") 
      or trigger_error($query->error, E_USER_WARNING);

    $query->bind_param("ii", $order[0], $order[1]);

    $query->execute() or trigger_error($query->error, E_USER_WARNING);
    $result = $query->get_result();
    $query->close();
    return $result;
  }
}
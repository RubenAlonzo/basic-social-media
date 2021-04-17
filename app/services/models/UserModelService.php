<?php
require_once __DIR__ . '/abstract/ModelServiceBase.php';

class UserModelService extends ModelServiceBase{
 
  public function Create($FirstName, $LastName, $Phone, $Email, $Username, $Password, $profileName, $IsEmailConfirmed, $hash){

    $query = $this->db->prepare(
      "INSERT INTO  user (first_name, last_name, phone, 
      email, username, password, profile_pic, email_confirmed, hash) 
      values (?, ?, ?, ?, ?, ?, ?, ?, ?)") or trigger_error($query->error, E_USER_WARNING);

    $query->bind_param("sssssssis", $FirstName, $LastName, 
      $Phone, $Email, $Username, $Password, 
      $profileName, $IsEmailConfirmed, $hash);

    $result = $query->execute() or trigger_error($query->error, E_USER_WARNING);
    $query->close();

    return $result;
  }

  public function TryGetByUsername($username){

    $query = $this->db->prepare("SELECT * FROM user WHERE username = ?") or trigger_error($query->error, E_USER_WARNING);

    $query->bind_param("s", $username);

    $query->execute() or trigger_error($query->error, E_USER_WARNING);
    $result = $query->get_result();
    $query->close();

    if($result->num_rows === 0) return array();
    return $result->fetch_object();
  }

  public function TryGetById($id){

    $query = $this->db->prepare("SELECT * FROM user WHERE id_user = ?") or trigger_error($query->error, E_USER_WARNING);

    $query->bind_param("i", $id);

    $query->execute() or trigger_error($query->error, E_USER_WARNING);
    $result = $query->get_result();
    $query->close();

    if($result->num_rows === 0) return array();
    return $result->fetch_object();
  }

  public function ConfirmEmail($username, $hash){
    
    $query = $this->db->prepare("SELECT * FROM user WHERE username = ? AND hash = ?")
     or trigger_error($query->error, E_USER_WARNING);

    $query->bind_param("ss", $username, $hash);

    $query->execute() or trigger_error($query->error, E_USER_WARNING);
    $result = $query->get_result();
    $query->close();

    if($result->num_rows === 0) return false;

    $query = $this->db->prepare("UPDATE user SET email_confirmed = 1 WHERE (username = ?);
    ")
    or trigger_error($query->error, E_USER_WARNING);

    $query->bind_param("s", $username);

    $query->execute() or trigger_error($query->error, E_USER_WARNING);
    $result = $query->get_result();
    $query->close();

    return true;  
  }
}
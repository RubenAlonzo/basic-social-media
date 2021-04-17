<?php
require_once __DIR__ . '/abstract/ModelServiceBase.php';

class UserModelService extends ModelServiceBase{
 
  public function Create($FirstName, $LastName, $Phone, $Email, $Username, $Password, $profileName, $IsEmailConfirmed){

    $query = $this->db->prepare(
      "INSERT INTO  user (first_name, last_name, phone, 
      email, username, password, profile_pic, email_confirmed) 
      values (?, ?, ?, ?, ?, ?, ?, ?)") or trigger_error($query->error, E_USER_WARNING);

    $query->bind_param("sssssssi", $FirstName, $LastName, 
      $Phone, $Email, $Username, $Password, 
      $profileName, $IsEmailConfirmed);

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
}
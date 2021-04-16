<?php
require_once __DIR__ . '/abstract/ModelServiceBase.php';

class UserModelService extends ModelServiceBase{
  public $Id = 'id_user';
  public $FirstName = 'first_name';
  public $LastName = 'last_name';
  public $Phone = 'phone';
  public $Email = 'email';
  public $Username = 'username';
  public $Password = 'password';
  public $ProfilePic = 'profile_pic';
  public $IsEmailConfirmed = 'email_confirmed';
  
  public function Create($entity){
    $query = $this->db->prepare(
      "INSERT INTO  user ($this->FirstName, $this->LastName, $this->Phone, 
      $this->Email, $this->Username, $this->Password, $this->ProfilePic,
      $this->IsEmailConfirmed) values (?, ?, ?, ?, ?, ?, ?, ?)") or trigger_error($query->error, E_USER_WARNING);

    $query->bind_param("sssssssi", $entity->FirstName, $entity->LastName, 
      $entity->Phone, $entity->Email, $entity->Username, $entity->Password, 
      $entity->ProfilePic, $entity->IsEmailConfirmed);
      $result = $query->execute() or trigger_error($query->error, E_USER_WARNING);
    $query->close();
    return $result;
  }

  public function TryGetByUsername($username){
    $query = $this->db->prepare("SELECT * FROM user WHERE $this->Username = ?") or trigger_error($query->error, E_USER_WARNING);

    $query->bind_param("s", $username);
    $query->execute() or trigger_error($query->error, E_USER_WARNING);
    $result = $query->get_result();
    $query->close();

    if($result->num_rows === 0) return array();

    return $result->fetch_object();
  }

  public function TryGetById($id){
    $query = $this->db->prepare("SELECT * FROM user WHERE $this->Id = ?") or trigger_error($query->error, E_USER_WARNING);

    $query->bind_param("i", $id);
    $query->execute() or trigger_error($query->error, E_USER_WARNING);
    $result = $query->get_result();
    $query->close();

    if($result->num_rows === 0) return array();

    return $result->fetch_object();
  }
}
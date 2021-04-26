<?php
require_once __DIR__ . '/../../../database/DbContext.php';
require_once __DIR__ . '/../../../Utilities/Utils.php';

abstract class ModelServiceBase{
  protected $db;
  
  public function __construct(){
    $this->db  = DbContext::getConnection();;
  }

  protected function RemoveImage($id, $table, $refCol){
    $query = $this->db->prepare(
      "SELECT image_content FROM {$table} WHERE {$refCol} = ?") 
      or trigger_error($query->error, E_USER_WARNING);
    $query->bind_param("i", $id);

    $query->execute() or trigger_error($query->error, E_USER_WARNING);
    $result = $query->get_result();
    $query->close();

    if($result->num_rows === 0) return null;

    while ($row = $result->fetch_object()) {
      Utils::DeleteFile(IMG_POST_PATH . '/' . $row->image_content);
    }
  }

  protected function TryGetRowById($fieldSearching, $table, $refCol, $id){
    $query = $this->db->prepare(
      "SELECT {$fieldSearching} FROM {$table} WHERE {$refCol} = ? LIMIT 1") 
      or trigger_error($query->error, E_USER_WARNING);

    $query->bind_param("i", $id);

    $query->execute() or trigger_error($query->error, E_USER_WARNING);
    $result = $query->get_result();
    $query->close();

    if($result->num_rows === 0) return null;

    if ($row = $result->fetch_object()) {
      return $row;
    }
    
    return null;
  }

  protected function TryGetListById($fieldSearching, $table, $refCol, $id){
    $query = $this->db->prepare(
      "SELECT {$fieldSearching} FROM {$table} WHERE {$refCol} = ? ") 
      or trigger_error($query->error, E_USER_WARNING);

    $query->bind_param("i", $id);

    $query->execute() or trigger_error($query->error, E_USER_WARNING);
    $result = $query->get_result();
    $query->close();

    if($result->num_rows === 0) return null;

    $List = array();
    while ($row = $result->fetch_object()) {
      array_push($List, $row);
    }
    return $List;
  }

  protected function DeleteById($table, $refCol, $id){
    $query = $this->db->prepare(
      "DELETE FROM {$table} WHERE ({$refCol} = ?)") 
      or trigger_error($query->error, E_USER_WARNING);
    $query->bind_param("i", $id);
    $result = $query->execute() or trigger_error($query->error, E_USER_WARNING);
    $query->close();
    return $result;
  }

  protected function UpdateFieldById($table, $fielToChange, $newValue, $refCol, $id){
    $query = $this->db->prepare(
      "UPDATE {$table} SET {$fielToChange} = ? WHERE ({$refCol} = ?)") 
      or trigger_error($query->error, E_USER_WARNING);
    $query->bind_param("si", $newValue, $id);
    $result = $query->execute() or trigger_error($query->error, E_USER_WARNING);
    $query->close();
    return $result;
  }
}
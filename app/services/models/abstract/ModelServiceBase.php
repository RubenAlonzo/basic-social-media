<?php
require_once __DIR__ . '/../../../database/DbContext.php';

abstract class ModelServiceBase{
  protected $db;
  
  public function __construct(){
    $this->db  = DbContext::getConnection();;
  }
}
<?php
require_once __DIR__ .'/Config.php';

class DbContext{
  private static $db;

  private function __construct() { }
  private function __clone() {}
  public function __wakeup(){
    throw new \Exception("Cannot unserialize a singleton.");
  }

  public static function getConnection()
  {
    if (!isset(self::$db)) {
      self::$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
      if (self::$db->connect_error) {
        exit('Error connecting to database');
      }
    }
    return self::$db;
  }
}

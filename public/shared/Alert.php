<?php
session_start();

class Alert{
  public static function PrintAlert($sessionName){
    if($_SESSION[$sessionName]){
      $type = $_SESSION[$sessionName][1];
      $message = $_SESSION[$sessionName][0];
      $strongMessage = ucfirst($type);
      $_SESSION[$sessionName] = '';
      echo <<<EOF
      <div class="alert alert-{$type} alert-dismissible fade show" role="alert">
      <strong>{$strongMessage}:</strong> {$message}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      EOF;
    }
  }
}
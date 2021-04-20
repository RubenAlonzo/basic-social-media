<?php
class Utils{

  public static function TryUploadImage($photoInfo, $dir, $customFileName = ''){
    if(!isset($photoInfo) || $photoInfo['error'] == 4) return null;
   
    $customFileName = $customFileName ? $customFileName : self::random_str(32);
    $fileExtention = str_replace('image/', '', $photoInfo['type']);
    $fileName = "{$customFileName}.{$fileExtention}";
    $size = $photoInfo['size'];
    $type = $photoInfo['type'];
    $tempFileName = $photoInfo['tmp_name'];
    $repeatedFilesId = glob($dir . $customFileName . '.*');

    if(($size < 1000000) 
    && ($type == 'image/gif' 
    || $type == 'image/jpeg'
    || $type == 'image/png'
    || $type == 'image/jpg'
    || $type == 'image/JPG'
    || $type == 'image/pjpeg')){

      if(!file_exists($dir)) mkdir($dir, 0777, true);
      while ($repeatedFilesId) {
        if(file_exists($repeatedFilesId[0])) unlink($repeatedFilesId[0]);
        $repeatedFilesId = glob($dir . $customFileName . '.*');
      }

      $isSuccess = move_uploaded_file($tempFileName, $dir .'/'.  $fileName);
      if($isSuccess) return $fileName;
    }
    else {
      return null;
    }
  } 

  public static function DeleteFile($filepath){
    if(file_exists($filepath)) unlink($filepath);
  }

  public static function SortOrder($a, $b){
    $ordered = array();
    if($a < $b){
      array_push($ordered, $a);
      array_push($ordered, $b);
    }
    else{
      array_push($ordered, $b);
      array_push($ordered, $a);
    }
    return $ordered;
  }

  public static function random_str(
    $length = 64, 
    $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'){
      if ($length < 1) {
        throw new \RangeException("Length must be a positive integer");
    }
    $pieces = [];
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $pieces []= $keyspace[random_int(0, $max)];
    }
    return implode('', $pieces);
  }
}
<?php
class Utils{

  public static function TryUploadImage($entityId, $photoInfo, $dir)
  {
    if(!isset($photoInfo) || $photoInfo['error'] == 4) return null;
   
    $fileExtention = str_replace('image/', '', $photoInfo['type']);
    $fileName = "{$entityId}.{$fileExtention}";
    $size = $photoInfo['size'];
    $type = $photoInfo['type'];
    $tempFileName = $photoInfo['tmp_name'];
    $repeatedFilesId = glob($dir . $entityId . '.*');

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
        $repeatedFilesId = glob($dir . $entityId . '.*');
      }

      $isSuccess = move_uploaded_file($tempFileName, $dir .'/'.  $fileName);
      if($isSuccess) return $fileName;
    }
    else {
      return null;
    }
  } 
}
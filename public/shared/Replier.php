<?php
require_once __DIR__ . '/../../app/services/models/ResponseModelService.php';
require_once __DIR__ . '/../../app/services/models/UserModelService.php';

class Replier{
  private $directoryUp;
  private $responseService;
  private $userService;

  public function __construct($isRoot = false){
    $this->directoryUp = ($isRoot) ? "public/" : "../";
    $this->responseService = new ResponseModelService();
    $this->userService = new UserModelService();
  }

  public function PrintReply($replyList){

    foreach($replyList as $reply){

      $replyer = $this->userService->TryGetById($reply->id_user);
echo <<<EOF
      <div class="ms-5 mt-4">
      <small class="float-end lead fs-6">{$reply->time_stamp}</small>
      <div class="d-flex text-muted pt-3 col-md-10">
      <img src='{$this->directoryUp}assets/img/profile/{$replyer->profile_pic}' width="40px" height="40px" style="border-radius: 50%; margin-right: 1%" alt="img">
      <p class="pb-3 mb-0 small lh-sm ">
      <strong class="d-block text-gray-dark">@{$replyer->username}</strong> 
      {$reply->text_content}
      </p>
      </div>
      <div class="border-bottom ms-5 pb-3">
EOF;
      if($reply->image_content)
        echo "<img src='{$this->directoryUp}assets/img/posts/{$reply->image_content}' width='240px' height='240px' alt='img'>";

echo <<<EOF
      </div>
      <div class="d-flex justify-content-start  mt-1 ms-5">
      <input type="hidden"  class="response" value="reply">
      <input type="hidden"  class="selfid" value='{$reply->id_reply}'>
      <a class="replyBtn" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#replyModal" >Reply</a>
      </div>      
EOF;
      while($reply->child_reply != null){
        $reply = $this->responseService->GetChildReply($reply->child_reply);
        $this->PrintReply($reply);
      }  
echo '</div>';
    }
  }
}
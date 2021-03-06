<?php
require_once __DIR__ . '/../../app/services/models/ResponseModelService.php';
require_once __DIR__ . '/../../app/services/models/UserModelService.php';
require_once __DIR__ . '/../../app/services/models/PostModelService.php';
require_once __DIR__ . '/Replier.php';

session_start();

class Posts{
  private $directoryUp;
  private $postService;
  private $replier;

  public function __construct($isRoot = false){
    $this->directoryUp = ($isRoot) ? "public/" : "../";
    $this->postService = new PostModelService();
    $this->replier = new Replier();
  }

  public function PrintPosts($currentUser, $page){

    $postList = $this->postService->GetListByUserId($currentUser->id_user);
    if($postList){
      foreach($postList as $userPost){
        $date = date("F j, Y, g:i a", strtotime($userPost->time_stamp));
echo <<<EOF
        <!-- Start Posts  -->

        <div class="my-3 p-3 bg-body rounded shadow col-md-8">
        <small class="float-end lead fs-6">{$date}</small>
        <div class="d-flex text-muted pt-3 col-md-10">
          <img src='{$this->directoryUp}assets/img/profile/{$currentUser->profile_pic}' width="40px" height="40px" style="border-radius: 50%; margin-right: 1%" alt="img">
          <p class="pb-3 mb-0 small lh-sm ">
          <strong class="d-block text-gray-dark">@{$currentUser->username}</strong> 
            {$userPost->text_content}
          </p>
        </div>
        <div class="border-bottom ms-5 pb-3">
EOF;
        if($userPost->image_content){
          echo "<img src='{$this->directoryUp}assets/img/posts/{$userPost->image_content}' width='240px' height='240px' alt='img'>";
        }

echo <<<EOF
        </div>
      <div class="d-flex justify-content-start  mt-1 ms-5">
        <input type="hidden"  class="postid" value='{$userPost->id_post}'>
        <input type="hidden"  class="selfid" value='0'>
        <input type="hidden"  class="page" value='{$page}'>
        <a class="actionBtn me-2" href="" data-bs-toggle="modal" data-bs-target="#replyModal" >Reply</a>
EOF;
        if($userPost->id_user == $currentUser->id_user){
          echo "<a href='javascript:void(0)' data-id='{$userPost->id_post}' data-page='{$page}' data-action='home/DeletePost' class='text-danger me-2 link-delete'>Delete</a>";
          echo "<a href='./Edit.php?id={$userPost->id_post}&type=post&page={$page}' class='text-success'>Edit</a>";
        }
        echo '</div>';
        $this->replier->PrintReply($userPost->id_post, $page);
        echo "</div>";
    }
  }
  else{
    echo ('<h5 class="lead my-5"><i class="bi bi-exclamation-diamond"></i> No post so far</h5>');
  }
}

  public function PrintFriendPosts($currentUser, $page){
    
    $postList = $this->postService->GetListFromFriendsByUserId($currentUser->id_user);
    if($postList){
      foreach($postList as $userPost){
        $date = date("F j, Y, g:i a", strtotime($userPost->time_stamp));
echo <<<EOF
        <!-- Start Posts  -->

        <div class="my-3 p-3 bg-body rounded shadow col-md-8">
        <small class="float-end lead fs-6">{$date}</small>
        <div class="d-flex text-muted pt-3 col-md-10">
          <img src='{$this->directoryUp}assets/img/profile/{$userPost->profile_pic}' width="40px" height="40px" style="border-radius: 50%; margin-right: 1%" alt="img">
          <p class="pb-3 mb-0 small lh-sm ">
          <strong class="d-block text-gray-dark">@{$userPost->username}</strong> 
            {$userPost->text_content}
          </p>
        </div>
          <div class="border-bottom ms-5 pb-3">
EOF;
          if($userPost->image_content){
            echo "<img src='{$this->directoryUp}assets/img/posts/{$userPost->image_content}' width='240px' height='240px' alt='img'>";
          }

echo <<<EOF
          </div>
        <div class="d-flex justify-content-start  mt-1 ms-5">
          <input type="hidden"  class="postid" value='{$userPost->id_post}'>
          <input type="hidden"  class="selfid" value='0'>
          <input type="hidden"  class="page" value='{$page}'>
          <a class="actionBtn me-2" href="" data-bs-toggle="modal" data-bs-target="#replyModal" >Reply</a>
EOF;
          if($userPost->id_user == $currentUser->id_user){
            echo "<a href='javascript:void(0)' data-id='{$userPost->id_post}' data-page='{$page}' data-action='home/DeletePost' class='text-danger me-2 link-delete'>Delete</a>";
            echo "<a href='./Edit.php?id={$userPost->id_post}&type=post&page={$page}' class='text-success'>Edit</a>";
          }
          echo '</div>';
          $this->replier->PrintReply($userPost->id_post, $page);
          echo "</div>";
      }
    }
    else{
      echo ('<h5 class="lead my-5"><i class="bi bi-exclamation-diamond"></i> No post so far</h5>');
    }
  }
}
<?php
require_once __DIR__ . '/../../public/shared/Layout.php';
require_once __DIR__ . '/../../public/shared/Alert.php';
require_once __DIR__ . '/../../public/shared/Posts.php';
require_once __DIR__ . '/../../app/Utilities/authorization.php';
require_once __DIR__ . '/../../app/services/models/FriendModelService.php';
require_once __DIR__ . '/../../app/database/Config.php';

Authorization::Authorize();
$layout = new Layout();
$posts = new Posts;
$friendsService = new FriendModelService();
$layout->PrintHead();
$layout->PrintHeaderAuth('friends');
Alert::PrintAlert('homeMessage');
$currentUser = $_SESSION['auth'];
$friends = $friendsService->TryGetFriendsById($currentUser->id_user);
?>

  <!-- Reply Modal -->
  <div class="modal fade" id="replyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Reply</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
          <form action="../../app/controllers/home/Response.php" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
              <input type="hidden" id="postid" name="postid" value="">
              <input type="hidden" id="parentid" name="parentid" value="">
              <textarea class="form-control mb-3" rows="4" placeholder="Leave a comment here" name="textresponse"></textarea>
              <input class="form-control form-control-sm mb-3" name="photoresponse" accept=".jpg,.png,.jpeg" type="file">
              </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary float-end">Publish</button>
            </div>
          </form>
      </div>
    </div>
  </div>

<main class="container-lefted mt-5">
    
  <div class="my-3 p-3 bg-body rounded shadow col-md-8">
      <h4 class="pb-2 mb-0">Look what your friends are doing</h4>
  </div>

  <?php $posts->PrintPosts($currentUser, 'Friends')?>

</main>


<div class="position-fixed shadow bottom-0 end-0 me-3 p-2 border border-info rounded">
  <h4 class="lead text-secondary fw-bolder">Add a new friend</h4>
  <form action="../../app/controllers/friends/AddFriend.php" method="POST">
    <div class="input-group mb-4">
      <input type="text" required class="form-control" name='username' placeholder="username">
      <button class="input-group-text btn btn-outline-success" type="submit"><i class="bi bi-person-plus"></i></button>
    </div>
  </form>

  <h4 class="lead text-secondary fw-bolder">Friend list</h4>
  <?php if(!$friends):?>
    <h4 class="lead text-center text-danger">Add some friends!</h4>
  <?php else:?>
    <?php foreach($friends as $friend):?>
      <ul class="list-group">
        <li class="list-group-item">
          <a href=<?= '../../app/controllers/friends/RemoveFriend.php?id=' .  $friend->id_user?> ><i class="text-danger bi bi-trash-fill"></i></a> 
          <?= $friend->first_name?> <?= $friend->last_name?> 
          <strong class="d-block text-secondary">@<?= $friend->username?></strong>  
        </li>
      </ul>
    <?php endforeach?>
  <?php endif?>

</div>

<?php
$layout->PrintFooter();
?>
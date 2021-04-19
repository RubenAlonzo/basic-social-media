<?php
require_once __DIR__ . '/../../public/shared/Layout.php';
require_once __DIR__ . '/../../public/shared/Alert.php';
require_once __DIR__ . '/../../public/shared/Replier.php';
require_once __DIR__ . '/../../app/services/models/PostModelService.php';
require_once __DIR__ . '/../../app/services/models/ResponseModelService.php';
require_once __DIR__ . '/../../app/services/models/UserModelService.php';
require_once __DIR__ . '/../../app/Utilities/authorization.php';
require_once __DIR__ . '/../../app/database/Config.php';

Authorization::Authorize();
$layout = new Layout();
$replier = new Replier();
$postService = new PostModelService();
$responseService = new ResponseModelService();
$userService = new UserModelService();
$layout->PrintHead();
$layout->PrintHeaderAuth();
Alert::PrintAlert('homeMessage');
$currentUser = $_SESSION['auth'];
?>

<main class="container-lefted mt-5">

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

  <!-- Edit Modal -->
  <!-- <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit</h5>
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
  </div> -->

  <!-- Create new posts secction -->
  <div class="my-3 p-3 bg-body rounded shadow col-md-8 ">
    <h3 class="border-bottom pb-2 mb-0">Welcome <?= $currentUser->first_name .' '. $currentUser->last_name ?>!</h3>
    <br>
    <h6 class="mb-0">Create a new Post</h6>
    <div class="d-flex text-muted pt-3">
      <img src='<?='../assets/img/profile/' . $currentUser->profile_pic?>' width="40px" height="40px" style="border-radius: 50%; margin-right: 1%" alt="img">
      <div class="form-floating col-md-10">
        <form action="../../app/controllers/home/NewPost.php" method="POST" enctype="multipart/form-data">
          <textarea class="form-control mb-3" rows="4" placeholder="Leave a comment here" name="textpost"></textarea>
          <input class="form-control form-control-sm mb-3" name="photopost" accept=".jpg,.png,.jpeg" type="file">
          <button type="submit" class="btn btn-primary float-end">Publish</button>
        </form>
      </div>
    </div>
  </div>

  <div class="my-3 p-3 bg-body rounded shadow col-md-8">
    <h4 class="pb-2 mb-0">Recent updates</h4>
  </div>

  <!-- Start Posts  -->
  <?php foreach($postService->GetListByUserId($currentUser->id_user) as $userPost):?>

  <div class="my-3 p-3 bg-body rounded shadow col-md-8">
    <small class="float-end lead fs-6"><?= $userPost->time_stamp?></small>
    <div class="d-flex text-muted pt-3 col-md-10">
      <img src='<?='../assets/img/profile/' . $currentUser->profile_pic?>' width="40px" height="40px" style="border-radius: 50%; margin-right: 1%" alt="img">
      <p class="pb-3 mb-0 small lh-sm ">
      <strong class="d-block text-gray-dark">@<?=$currentUser->username?></strong> 
        <?= $userPost->text_content?>
      </p>
    </div>
      <div class="border-bottom ms-5 pb-3">
      <?php if($userPost->image_content):?>
        <img src='<?='../assets/img/posts/' . $userPost->image_content?>' width="240px" height="240px" alt="img">
      <?php endif?>
      </div>
    <div class="d-flex justify-content-start  mt-1 ms-5">
      <input type="hidden"  class="postid" value='<?= $userPost->id_post?>'>
      <input type="hidden"  class="selfid" value='<?= 0?>'>
      <a class="actionBtn me-2" href="" data-bs-toggle="modal" data-bs-target="#replyModal" >Reply</a>
      <?php if($userPost->id_user == $currentUser->id_user):?>
      <a href=<?='../../app/controllers/account/DeletePost.php?id='.$userPost->id_post?>  class="text-danger me-2">Delete</a>
      <a href="" data-bs-toggle="modal" data-bs-target="#editModal" class="text-success">Edit</a>
      <?php endif?>
    </div>

      <!-- Start reply -->

      <?php $replier->PrintReply($userPost->id_post)?>

      <!-- End reply -->

  </div>

  <?php endforeach;?>
  <!-- End Post -->

</main>

<?php
$layout->PrintFooter();
?>
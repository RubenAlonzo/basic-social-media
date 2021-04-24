<?php
require_once __DIR__ . '/../../public/shared/Layout.php';
require_once __DIR__ . '/../../public/shared/Alert.php';
require_once __DIR__ . '/../../public/shared/Posts.php';
require_once __DIR__ . '/../../app/Utilities/authorization.php';
require_once __DIR__ . '/../../app/database/Config.php';

Authorization::Authorize();
$layout = new Layout();
$posts = new Posts();

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
              <input type="hidden" id="page" name="page" value="">
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

  <?php $posts->PrintPosts($currentUser, 'Home')?>

</main>

<?php
$layout->PrintFooter();
?>
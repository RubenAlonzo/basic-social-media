<?php
require_once __DIR__ . '/../../public/shared/Layout.php';
require_once __DIR__ . '/../../public/shared/Alert.php';
require_once __DIR__ . '/../../public/shared/Posts.php';
require_once __DIR__ . '/../../public/shared/Modals.php';
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

  <?php $posts->PrintPosts($currentUser)?>

</main>

<?php
$layout->PrintFooter();
?>
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
  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Launch demo modal
  </button>
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">status</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div id="carouselExampleIndicators" class="carousel slide mx-auto" data-bs-ride="carousel">
            <div class="carousel-indicators">
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
              <div class="carousel-item active">
                <div class="bg-dark">
                  <img src="http://ekkotek.com/MobileApps/youtubeApi/examples/images/Swan_large.jpg" class="d-block w-100 img-fluid" alt="...">
                </div>
              </div>
              <div class="carousel-item">
                <div class="bg-dark">
                  <img src="https://i.pinimg.com/originals/2c/19/36/2c1936564a54f433efc263d1fc24cd19.jpg" class="d-block w-100 img-fluid" alt="...">
                </div>
              </div>
              <div class="carousel-item">
                <div class="bg-dark">
                  <img src="https://www.gettyimages.es/gi-resources/images/frontdoor/editorial/Velo/GettyImages-Velo-1088643550.jpg" class="d-block w-100 img-fluid" alt="...">
                </div>
              </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>

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
              <input type="hidden" id="responsetype" name="responsetype" value="">
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
<!-- As I get the post from the Current user, all possible responses are only from his friends -->
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
    <input type="hidden"  class="response" value="comment">
    <input type="hidden"  class="selfid" value='<?= $userPost->id_post?>'>
    <a class="replyBtn" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#replyModal" >Reply</a>
  </div>

    <!-- Start comment -->
    <?php foreach($responseService->GetList($userPost->id_post, 'comment') as $comment):?>
      <?php $commenter = $userService->TryGetById($comment->id_user);?>

      <div class="ms-5 mt-4">
        <small class="float-end lead fs-6"><?= $comment->time_stamp?></small>
        <div class="d-flex text-muted pt-3 col-md-10">
          <img src='<?='../assets/img/profile/' . $commenter->profile_pic?>' width="40px" height="40px" style="border-radius: 50%; margin-right: 1%" alt="img">
          <p class="pb-3 mb-0 small lh-sm ">
            <strong class="d-block text-gray-dark">@<?=$commenter->username?></strong> 
            <?= $comment->text_content?>
          </p>
        </div>
        <div class="border-bottom ms-5 pb-3">
          <?php if($comment->image_content):?>
          <img src='<?='../assets/img/posts/' . $comment->image_content?>' width="240px" height="240px" alt="img">
          <?php endif?>
        </div>
        <div class="d-flex justify-content-start  mt-1 ms-5">
          <input type="hidden"  class="response" value="reply">
          <input type="hidden"  class="selfid" value='<?= $comment->id_comment?>'>
          <a class="replyBtn" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#replyModal" >Reply</a>
        </div>


        <!-- Start reply -->

        <?php $replier->PrintReply($responseService->GetList($comment->id_comment, 'reply'))?>

   
        <!-- End reply -->


      </div>

    <?php endforeach;?>
    <!-- End Comment -->

</div>

<?php endforeach;?>
<!-- End Post -->

<!-- official -->

<div class="my-3 p-3 bg-body rounded shadow col-md-8">
  <small class="float-end lead fs-5">15-02-2021</small>
  <div class="d-flex text-muted pt-3 col-md-10">
    <title>Placeholder</title>
    <img src='<?='../assets/img/profile/' . $currentUser->profile_pic?>' width="40px" height="40px" style="border-radius: 50%; margin-right: 1%" alt="img">
    <p class="pb-3 mb-0 small lh-sm ">
      <strong class="d-block text-gray-dark">@<?=$currentUser->username?></strong> 
      Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aliquam dolor ut odio, vero iusto ipsum nesciunt saepe deserunt est deleniti, maxime labore unde eligendi autem itaque illo sint, beatae natus!
    </p>
  </div>
  <div class="border-bottom ms-5 pb-3">
    <img src='<?='../assets/img/profile/' . $currentUser->profile_pic?>' class="img-fluid" width="80%"  alt="img">
  </div>
  <div class="d-flex justify-content-start  mt-1 ms-5">
    <a href="#">Reply</a>
  </div>
  <div class="ms-5 mt-4">
    <small class="float-end lead fs-6">15-02-2021</small>
    <div class="d-flex text-muted pt-3 col-md-10">
      <title>Placeholder</title>
      <img src='<?='../assets/img/profile/' . $currentUser->profile_pic?>' width="40px" height="40px" style="border-radius: 50%; margin-right: 1%" alt="img">
      <p class="pb-3 mb-0 small lh-sm ">
        <strong class="d-block text-gray-dark">@<?=$currentUser->username?></strong> 
        Some representative placeholder content, with some information about this user. Imagine this being some sort of status update, perhaps?
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus, dolores! Vitae quibusdam voluptates, optio architecto incidunt neque porro consequatur dolor nobis impedit pariatur voluptatibus tempora omnis praesentium expedita sit esse!
      </p>
    </div>
    <div class="border-bottom ms-5 pb-1">
    </div>
    <div class="d-flex justify-content-start  mt-1 ms-5">
      <a href="#">Reply</a>
    </div>
    <div class="ms-5 mt-4">
      <small class="float-end lead fs-6">15-02-2021</small>
      <div class="d-flex text-muted pt-3 col-md-10">
        <title>Placeholder</title>
        <img src='<?='../assets/img/profile/' . $currentUser->profile_pic?>' width="40px" height="40px" style="border-radius: 50%; margin-right: 1%" alt="img">
        <p class="pb-3 mb-0 small lh-sm ">
          <strong class="d-block text-gray-dark">@<?=$currentUser->username?></strong> 
          Some representative placeholder content, with some information about this user. Imagine this being some sort of status update, perhaps?
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus, dolores! Vitae quibusdam voluptates, optio architecto incidunt neque porro consequatur dolor nobis impedit pariatur voluptatibus tempora omnis praesentium expedita sit esse!
        </p>
      </div>
      <div class="border-bottom ms-5 pb-1">
      </div>
      <div class="d-flex justify-content-start  mt-1 ms-5">
        <a href="#">Reply</a>
      </div>
    </div>
  </div>
</div>

<!-- official -->

<!-- Reply -->
<div class="ms-5 mt-4">
  <small class="float-end lead fs-6">15-02-2021</small>
  <div class="d-flex text-muted pt-3 col-md-10">
    <img src='<?='../assets/img/profile/' . $currentUser->profile_pic?>' width="40px" height="40px" style="border-radius: 50%; margin-right: 1%" alt="img">
    <p class="pb-3 mb-0 small lh-sm ">
      <strong class="d-block text-gray-dark">@<?=$currentUser->username?></strong> 
      Some representative placeholder content, with some information about this user. Imagine this being some sort of status update, perhaps?
      Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus, dolores! Vitae quibusdam voluptates, optio architecto incidunt neque porro consequatur dolor nobis impedit pariatur voluptatibus tempora omnis praesentium expedita sit esse!
    </p>
  </div>
  <div class="border-bottom ms-5 pb-1"></div>
  <div class="d-flex justify-content-start  mt-1 ms-5">
    <a href="#">Reply</a>
  </div>
</div>
<!-- Reply -->

</main>

<?php
$layout->PrintFooter();
?>
<?php
require_once __DIR__ . '/../../public/shared/Layout.php';
require_once __DIR__ . '/../../app/Utilities/authorization.php';
require_once __DIR__ . '/../../app/services/models/PostModelService.php';
require_once __DIR__ . '/../../app/database/Config.php';
require_once __DIR__ . '/../../public/shared/Alert.php';

Authorization::Authorize();
$currentUser = $_SESSION['auth'];
$layout = new Layout();
$posts = new PostModelService();
$layout->PrintHead();
$layout->PrintHeaderAuth();
Alert::PrintAlert('homeMessage');
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
<?php foreach($posts->GetListByUserId($currentUser->id_user) as $userPost):?>

<div class="my-3 p-3 bg-body rounded shadow col-md-8">
  <small class="float-end lead fs-6"><?= $userPost->time_stamp?></small>
  <div class="d-flex text-muted pt-3 col-md-10">
    <title>Placeholder</title>
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
    <a href="#">Reply</a>
  </div>
</div>

<?php endforeach;?>

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









  <div class="my-3 p-3 bg-body rounded shadow col-md-8">
    <h6 class="border-bottom pb-2 mb-0">Recent updates</h6>
    <div class="d-flex text-muted pt-3">
      <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false">
        <title>Placeholder</title>
        <rect width="100%" height="100%" fill="#007bff"></rect>
        <text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text>
      </svg>
      <p class="pb-3 mb-0 small lh-sm border-bottom">
        <strong class="d-block text-gray-dark">@username</strong>
        Some representative placeholder content, with some information about this user. Imagine this being some sort of status update, perhaps?
      </p>
      <div class="row">
        <a href="http://" class="mb-0 pb-0" target="_blank" rel="noopener noreferrer"> Reply</a>
      </div>
    </div>
    <div class="ms-5">
      <div class="d-flex text-muted pt-3">
        <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false">
          <title>Placeholder</title>
          <rect width="100%" height="100%" fill="#007bff"></rect>
          <text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text>
        </svg>
        <p class="pb-3 mb-0 small lh-sm border-bottom">
          <strong class="d-block text-gray-dark">@username</strong>
          Some representative placeholder content, with some information about this user. Imagine this being some sort of status update, perhaps?
        </p>
      </div>
      <div class="ms-5">
        <div class="d-flex text-muted pt-3">
          <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false">
            <title>Placeholder</title>
            <rect width="100%" height="100%" fill="#007bff"></rect>
            <text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text>
          </svg>
          <p class="pb-3 mb-0 small lh-sm border-bottom">
            <strong class="d-block text-gray-dark">@username</strong>
            Some representative placeholder content, with some information about this user. Imagine this being some sort of status update, perhaps?
          </p>
        </div>
      </div>
      <div class="d-flex text-muted pt-3">
        <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false">
          <title>Placeholder</title>
          <rect width="100%" height="100%" fill="#007bff"></rect>
          <text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text>
        </svg>
        <p class="pb-3 mb-0 small lh-sm border-bottom">
          <strong class="d-block text-gray-dark">@username</strong>
          Some representative placeholder content, with some information about this user. Imagine this being some sort of status update, perhaps?
        </p>
      </div>
    </div>
  </div>
  <div class="my-3 p-3 bg-body rounded shadow col-md-8">
    <h6 class="border-bottom pb-2 mb-0">Recent updates</h6>
    <div class="d-flex text-muted pt-3">
      <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false">
        <title>Placeholder</title>
        <rect width="100%" height="100%" fill="#007bff"></rect>
        <text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text>
      </svg>
      <p class="pb-3 mb-0 small lh-sm border-bottom">
        <strong class="d-block text-gray-dark">@username</strong>
        Some representative placeholder content, with some information about this user. Imagine this being some sort of status update, perhaps?
      </p>
    </div>
    <div class="d-flex text-muted pt-3">
      <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false">
        <title>Placeholder</title>
        <rect width="100%" height="100%" fill="#e83e8c"></rect>
        <text x="50%" y="50%" fill="#e83e8c" dy=".3em">32x32</text>
      </svg>
      <p class="pb-3 mb-0 small lh-sm border-bottom">
        <strong class="d-block text-gray-dark">@username</strong>
        Some more representative placeholder content, related to this other user. Another status update, perhaps.
      </p>
    </div>
    <div class="d-flex text-muted pt-3">
      <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false">
        <title>Placeholder</title>
        <rect width="100%" height="100%" fill="#6f42c1"></rect>
        <text x="50%" y="50%" fill="#6f42c1" dy=".3em">32x32</text>
      </svg>
      <p class="pb-3 mb-0 small lh-sm border-bottom">
        <strong class="d-block text-gray-dark">@username</strong>
        This user also gets some representative placeholder content. Maybe they did something interesting, and you really want to highlight this in the recent updates.
      </p>
    </div>
    <small class="d-block text-end mt-3">
    <a href="https://getbootstrap.com/docs/5.0/examples/offcanvas-navbar/#">All updates</a>
    </small>
  </div>
  <div class="my-3 p-3 bg-body rounded shadow col-md-8">
    <h6 class="border-bottom pb-2 mb-0">Recent updates</h6>
    <div class="d-flex text-muted pt-3">
      <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false">
        <title>Placeholder</title>
        <rect width="100%" height="100%" fill="#007bff"></rect>
        <text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text>
      </svg>
      <p class="pb-3 mb-0 small lh-sm border-bottom">
        <strong class="d-block text-gray-dark">@username</strong>
        Some representative placeholder content, with some information about this user. Imagine this being some sort of status update, perhaps?
      </p>
    </div>
    <div class="d-flex text-muted pt-3">
      <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false">
        <title>Placeholder</title>
        <rect width="100%" height="100%" fill="#e83e8c"></rect>
        <text x="50%" y="50%" fill="#e83e8c" dy=".3em">32x32</text>
      </svg>
      <p class="pb-3 mb-0 small lh-sm border-bottom">
        <strong class="d-block text-gray-dark">@username</strong>
        Some more representative placeholder content, related to this other user. Another status update, perhaps.
      </p>
    </div>
    <div class="d-flex text-muted pt-3">
      <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false">
        <title>Placeholder</title>
        <rect width="100%" height="100%" fill="#6f42c1"></rect>
        <text x="50%" y="50%" fill="#6f42c1" dy=".3em">32x32</text>
      </svg>
      <p class="pb-3 mb-0 small lh-sm border-bottom">
        <strong class="d-block text-gray-dark">@username</strong>
        This user also gets some representative placeholder content. Maybe they did something interesting, and you really want to highlight this in the recent updates.
      </p>
    </div>
    <small class="d-block text-end mt-3">
    <a href="https://getbootstrap.com/docs/5.0/examples/offcanvas-navbar/#">All updates</a>
    </small>
  </div>
  <div class="my-3 p-3 bg-body rounded shadow col-md-8">
    <h6 class="border-bottom pb-2 mb-0">Recent updates</h6>
    <div class="d-flex text-muted pt-3">
      <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false">
        <title>Placeholder</title>
        <rect width="100%" height="100%" fill="#007bff"></rect>
        <text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text>
      </svg>
      <p class="pb-3 mb-0 small lh-sm border-bottom">
        <strong class="d-block text-gray-dark">@username</strong>
        Some representative placeholder content, with some information about this user. Imagine this being some sort of status update, perhaps?
      </p>
    </div>
    <div class="d-flex text-muted pt-3">
      <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false">
        <title>Placeholder</title>
        <rect width="100%" height="100%" fill="#e83e8c"></rect>
        <text x="50%" y="50%" fill="#e83e8c" dy=".3em">32x32</text>
      </svg>
      <p class="pb-3 mb-0 small lh-sm border-bottom">
        <strong class="d-block text-gray-dark">@username</strong>
        Some more representative placeholder content, related to this other user. Another status update, perhaps.
      </p>
    </div>
    <div class="d-flex text-muted pt-3">
      <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false">
        <title>Placeholder</title>
        <rect width="100%" height="100%" fill="#6f42c1"></rect>
        <text x="50%" y="50%" fill="#6f42c1" dy=".3em">32x32</text>
      </svg>
      <p class="pb-3 mb-0 small lh-sm border-bottom">
        <strong class="d-block text-gray-dark">@username</strong>
        This user also gets some representative placeholder content. Maybe they did something interesting, and you really want to highlight this in the recent updates.
      </p>
    </div>
    <small class="d-block text-end mt-3">
    <a href="https://getbootstrap.com/docs/5.0/examples/offcanvas-navbar/#">All updates</a>
    </small>
  </div>
  <div class="my-3 p-3 bg-body rounded shadow col-md-8">
    <h6 class="border-bottom pb-2 mb-0">Recent updates</h6>
    <div class="d-flex text-muted pt-3">
      <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false">
        <title>Placeholder</title>
        <rect width="100%" height="100%" fill="#007bff"></rect>
        <text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text>
      </svg>
      <p class="pb-3 mb-0 small lh-sm border-bottom">
        <strong class="d-block text-gray-dark">@username</strong>
        Some representative placeholder content, with some information about this user. Imagine this being some sort of status update, perhaps?
      </p>
    </div>
    <div class="d-flex text-muted pt-3">
      <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false">
        <title>Placeholder</title>
        <rect width="100%" height="100%" fill="#e83e8c"></rect>
        <text x="50%" y="50%" fill="#e83e8c" dy=".3em">32x32</text>
      </svg>
      <p class="pb-3 mb-0 small lh-sm border-bottom">
        <strong class="d-block text-gray-dark">@username</strong>
        Some more representative placeholder content, related to this other user. Another status update, perhaps.
      </p>
    </div>
    <div class="d-flex text-muted pt-3">
      <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false">
        <title>Placeholder</title>
        <rect width="100%" height="100%" fill="#6f42c1"></rect>
        <text x="50%" y="50%" fill="#6f42c1" dy=".3em">32x32</text>
      </svg>
      <p class="pb-3 mb-0 small lh-sm border-bottom">
        <strong class="d-block text-gray-dark">@username</strong>
        This user also gets some representative placeholder content. Maybe they did something interesting, and you really want to highlight this in the recent updates.
      </p>
    </div>
    <small class="d-block text-end mt-3">
    <a href="https://getbootstrap.com/docs/5.0/examples/offcanvas-navbar/#">All updates</a>
    </small>
  </div>
</main>

<?php
$layout->PrintFooter();
?>
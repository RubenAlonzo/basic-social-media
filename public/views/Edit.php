<?php
require_once __DIR__ . '/../../public/shared/Layout.php';
require_once __DIR__ . '/../../public/shared/Alert.php';
require_once __DIR__ . '/../../public/shared/Posts.php';
require_once __DIR__ . '/../../app/Utilities/authorization.php';
require_once __DIR__ . '/../../app/database/Config.php';
require_once __DIR__ . '/../../app/services/models/PostModelService.php';
require_once __DIR__ . '/../../app/services/models/ResponseModelService.php';

Authorization::Authorize();
$layout = new Layout();
$posts = new Posts();
?>

<?php if((isset($_GET['id'])) 
&& trim($_GET['id']) 
&& (isset($_GET['type'])) 
&& trim($_GET['type'])):?>

<?php
$id =  trim($_GET['id']);
$type =  trim($_GET['type']);

$service = null;
switch ($type) {
  case 'post':
    $service = new PostModelService();
    break;
  case 'reply':
    $service = new ResponseModelService();
}
$content = ($service != null) ? $service->TryGetValuesById($id) : null;
?>

<?php
if($content == null) $_SESSION['editMessage'] = ['No content', 'warning'];
$layout->PrintHead();
$layout->PrintHeaderAuth();
Alert::PrintAlert('editMessage');
$currentUser = $_SESSION['auth'];
?>

<?php if($content != null):?>

<main class="container">

  <div class="col-md-6 mx-auto mt-5">
  <h3>Edit</h3>
  <br>
  <form action="../../app/controllers/home/Edit.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" id="id" name="id" value='<?= $id?>'>
      <input type="hidden" id="type" name="type" value='<?= $type?>'>
      <input type="hidden" id="imageName" name="imageName" value='<?= $content->image_content?>'>
      <textarea class="form-control mb-3" rows="4" placeholder="Leave a comment here" name="text"><?= $content->text_content?></textarea>
      <?php if($content->image_content):?>
          <div class="card text-center mb-2" >
            <h5 class="card-text lead">Current image</h5>
            <img src=<?="../assets/img/posts/{$content->image_content}"?> class="d-block mx-auto" width='120px' height='120px' alt='img'>
          </div>
      <?php endif?>
      <input class="form-control form-control-sm mb-3" name="photo" accept=".jpg,.png,.jpeg" type="file">
      <div class="d-grid gap-2">
        <button class="btn btn-primary" type="submit">Update</button>
      </div>
  </form>
  </div>

</main>

<?php endif?>

<?php
$layout->PrintFooter();
?>

<?php endif?>
<?php
require_once __DIR__ . '/../../public/shared/Layout.php';
require_once __DIR__ . '/../../public/shared/Alert.php';
require_once __DIR__ . '/../../public/shared/Posts.php';
require_once __DIR__ . '/../../app/Utilities/authorization.php';
require_once __DIR__ . '/../../app/database/Config.php';

Authorization::Authorize();
$layout = new Layout();
$posts = new Posts;
$layout->PrintHead();
$layout->PrintHeaderAuth('friends');
Alert::PrintAlert('friendsMessage');
$currentUser = $_SESSION['auth'];
?>

<main class="container-lefted mt-5">
    
  <div class="my-3 p-3 bg-body rounded shadow col-md-8">
      <h4 class="pb-2 mb-0">Look what your friends are doing</h4>
  </div>

  <?php $posts->PrintPosts($currentUser)?>

</main>

<?php
$layout->PrintFooter();
?>
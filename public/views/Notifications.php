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
$layout->PrintHeaderAuth('notifications');
Alert::PrintAlert('homeMessage');
$currentUser = $_SESSION['auth'];
?>

<main class="container-lefted mt-5 col-md-8">

<h4>Friendship requests:</h4>


<ul class="list-group list-group-flush">
  <li class="list-group-item d-flex mb-3 border mb-3 col-md-6">
    <div class="">
      <i class="bi bi-people-fill text-primary"></i>
      Emilio Alcantara Reynoso 
      <strong class="d-block text-secondary">@ElManolo24</strong>
    </div>
    <div class="ms-5 mt-2">
      <button class="btn btn-outline-success btn-sm me-3"> Accept</button>
      <button class="btn btn-outline-danger btn-sm"> Decline</button>
    </div>
   </li>
</ul>

</main>

<?php
$layout->PrintFooter();
?>
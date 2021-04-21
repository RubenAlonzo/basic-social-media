<?php
require_once __DIR__ . '/../../public/shared/Layout.php';
require_once __DIR__ . '/../../public/shared/Alert.php';
require_once __DIR__ . '/../../app/Utilities/authorization.php';
require_once __DIR__ . '/../../app/services/models/FriendModelService.php';

Authorization::Authorize();
$layout = new Layout();
$friendService = new FriendModelService();
$layout->PrintHead();
$layout->PrintHeaderAuth('notifications');
Alert::PrintAlert('notificationMessage');
$currentUser = $_SESSION['auth'];
$requests = $friendService->GetPendingRequests($currentUser->id_user);
?>

<main class="container-lefted mt-5 ">


<div class="my-3 p-3 bg-body rounded shadow col-md-8">
  <h4 class="pb-2 mb-0">Friendship requests</h4>
</div>

<?php if($requests):?>
  <?php foreach($requests as $request):?>
  <ul class="p-3 list-group list-group-flush">
    <li class="row shadow rounded list-group-item d-flex mb-3 border border-success mb-3 col-md-4">
      <div class="col">
        <i class="bi bi-people-fill text-primary"></i>
        <?= $request->first_name?> <?= $request->last_name?>
        <strong class="d-block text-secondary">@<?= $request->username?></strong>
      </div>
      <div class="ms-5 col mt-2 d-flex">
        <form action="../../app/controllers/notifications/RequestAnswer.php" method="POST">
          <input type="hidden" name="id" value='<?= $request->id_user?>'>
          <input type="hidden" name="response" value='accept'>
          <button type="submit" class="btn btn-outline-success btn-sm me-3"><i class="bi bi-check-circle-fill"></i> Accept</button>
        </form>
        <form action="../../app/controllers/notifications/RequestAnswer.php" method="POST">
          <input type="hidden"  name="id" value='<?= $request->id_user?>'>
          <input type="hidden"  name="response" value='decline'>
          <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-x-circle-fill"></i> Decline</button>
        </form>
      </div>
    </li>
  </ul>
  <?php endforeach?>
<?php else:?>
<h5 class="lead my-5"><i class="bi bi-exclamation-diamond"></i>
You don't have any pending requests</h5>
<?php endif?>
</main>

<?php
$layout->PrintFooter();
?>
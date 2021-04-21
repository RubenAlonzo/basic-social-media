<?php
require_once __DIR__ . '/../../public/shared/Layout.php';
require_once __DIR__ . '/../../public/shared/Alert.php';
require_once __DIR__ . '/../../app/Utilities/authorization.php';
require_once __DIR__ . '/../../app/services/models/FriendModelService.php';

Authorization::Authorize();
$layout = new Layout();
$friendService = new FriendModelService();
$layout->PrintHead();
$layout->PrintHeaderAuth('events');
$layout->PrintEventsTabs('invitations');
Alert::PrintAlert('notificationMessage');
$currentUser = $_SESSION['auth'];
$requests = $friendService->GetPendingRequests($currentUser->id_user);
?>

<main class="container-lefted mt-5">

<div class="my-3 p-3 bg-body rounded shadow col-md-8">
  <h4 class="pb-2 mb-0">Friend's invitations to events</h4>
</div>

<ul class="list-group p-3 col-md-8 list-group-flush">

  <li class="row shadow rounded list-group-item d-flex mb-3 border mb-3 col-md-8">
    <div class="col">
      <i class="bi bi-calendar-event text-primary"></i>
      <span>15/07/2021 15:00</span> <small class="text-danger ms-3">Expired</small>
      <strong class="d-block text-secondary">International Seminar on Pedagogical Approaches</strong>
      <span class="d-block fst-italic text-secondary">Fort Lauderdale, Florida</span>
      <small class="d-block text-secondary">12 people invited</small>

      <form action="" class="mt-3">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
          <label class="form-check-label text-primary fw-bold" for="inlineRadio1">Interested</label>
          </div>
          <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
          <label class="form-check-label text-success fw-bold" for="inlineRadio2">Going</label>
          </div>
          <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3">
          <label class="form-check-label text-danger fw-bold" for="inlineRadio3">Can't make it</label>
        </div>   
        <button type="submit" class="btn btn-secondary btn-sm">Send response</button>
      </form>

    </div>
  </li>

</ul>

</main>


<?php
$layout->PrintFooter();
?>
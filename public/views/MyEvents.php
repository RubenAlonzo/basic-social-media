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
$layout->PrintEventsTabs('myevents');
Alert::PrintAlert('myEventMessage');
$currentUser = $_SESSION['auth'];
$requests = $friendService->GetPendingRequests($currentUser->id_user);
?>

<!-- Reply Modal -->
<div class="modal fade" id="newEvent" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">New event</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <form action="../../app/controllers/MyEvents/NewEvent.php" method="POST">
          <div class="modal-body">
            <div class="mb-3">
              <label for="title" class="form-label">Title</label>
              <input type="text" class="form-control" name="title" required >
            </div>
            <div class="mb-3">
              <label for="title" class="form-label">Place</label>
              <input type="text" class="form-control" name="title" required >
            </div>
            <div class="mb-3">
              <label for="title" class="form-label">Date and Time</label>
              <input type="datetime-local"  min='<?= date('Y-m-d\TH:i')?>' class="form-control" name="title" required >
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary float-end">Create</button>
          </div>
        </form>
    </div>
  </div>
</div>

<main class="container-lefted mt-5">

<div class="my-3 p-3 bg-body rounded shadow col-md-8">
  <h4 class="pb-2 mb-0">Events created by me</h4>
</div>

<button class="btn btn-primary shadow" data-bs-toggle="modal" data-bs-target="#newEvent"><i class="bi bi-calendar-plus"></i> Create event</button>

<ul class="list-group p-3 col-md-8 list-group-flush">
    
    <li class="row shadow rounded list-group-item d-flex mb-3 border mb-3 col-md-8">
      <div class="col">
        <i class="bi bi-calendar-event text-primary"></i>
        <span>15/07/2021 15:00</span> <small class="text-danger ms-3">Expired</small>
        <strong class="d-block text-secondary">International Seminar on Pedagogical Approaches</strong>
        <span class="d-block fst-italic text-secondary">Fort Lauderdale, Florida</span>
        <small class="d-block text-secondary">12 people invited</small>
        <div class="row mt-4">
          <div class="col">
            <a href='<?="./ManageEvents.php?id={}"?>' class='btn btn-outline-success btn-sm me-3 d-block'><i class="bi bi-three-dots-vertical"></i> Details</a>
          </div>
          <div class="col">
            <a href='<?="./Edit.php?id=4"?>' class='btn btn-outline-danger btn-sm me-3 d-block'><i class="bi bi-x-circle-fill"></i> Delete</a>
          </div>
        </div>
      </div>
    </li>

  </ul>

</main>


<?php
$layout->PrintFooter();
?>
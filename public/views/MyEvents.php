<?php
require_once __DIR__ . '/../../public/shared/Layout.php';
require_once __DIR__ . '/../../public/shared/Alert.php';
require_once __DIR__ . '/../../app/Utilities/authorization.php';
require_once __DIR__ . '/../../app/services/models/EventModelService.php';

Authorization::Authorize();
$layout = new Layout();
$eventService = new EventModelService();
$layout->PrintHead();
$layout->PrintHeaderAuth('events');
Alert::PrintAlert('myEventMessage');
$layout->PrintEventsTabs('myevents');
$currentUser = $_SESSION['auth'];
$myEvents = $eventService->GetMyEvents($currentUser->id_user);
?>

<!-- New event -->
<div class="modal fade" id="newEvent" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">New event</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <form action="../../app/controllers/myevents/NewEvent.php" method="POST">
          <div class="modal-body">
            <div class="mb-3">
              <label for="title" class="form-label">Title</label>
              <input type="text" class="form-control" name="title" required >
            </div>
            <div class="mb-3">
              <label for="place" class="form-label">Place</label>
              <input type="text" class="form-control" name="place" required >
            </div>
            <div class="mb-3">
              <label for="date" class="form-label">Date and Time</label>
              <input type="datetime-local"  min='<?= date('Y-m-d\TH:i')?>' class="form-control" name="date" required >
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
    <?php foreach($myEvents as $event):?>
    <li class="row shadow rounded list-group-item d-flex mb-3 border mb-3 col-md-8">
      <div class="col">
        <i class="bi bi-calendar-event text-primary"></i>
        <span><?= $event->date?></span> 
          <?php if(Utils::IsDateAfterNow($event->date)):?>
            <small class="text-success fw-bold ms-3">Active</small>
          <?php else:?>
            <small class="text-danger fw-bold ms-3">Expired</small>
          <?php endif?>
        <strong class="d-block text-secondary"><?= $event->title?></strong>
        <span class="d-block fst-italic text-secondary"><?= $event->place?></span>
        <small class="d-block text-secondary mt-1"><?php echo count($eventService->GetInvitationsToEvent($event->id_event))?> people invited</small>
        <div class="row mt-4">
          <div class="col">
            <a href='<?="./ManageEvents.php?id={$event->id_event}"?>' class='btn btn-outline-success btn-sm me-3 d-block'><i class="bi bi-three-dots-vertical"></i> Details</a>
          </div>
          <div class="col">
            <a href='javascript:void(0)' data-id='<?= $event->id_event?>' data-page='' data-action='myevents/DeleteEvent' class='link-delete btn btn-outline-danger btn-sm me-3 d-block'><i class="text-danger bi bi-trash-fill"></i> Delete</a>
          </div>
        </div>
      </div>
    </li>
    <?php endforeach?>

  </ul>

</main>


<?php
$layout->PrintFooter();
?>
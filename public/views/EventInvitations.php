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
Alert::PrintAlert('eventInvitationMessage');
$layout->PrintEventsTabs('invitations');
$currentUser = $_SESSION['auth'];
$invitations = $eventService->GetEventInvitations($currentUser->id_user);
?>

<main class="container-lefted mt-5">

<div class="my-3 p-3 bg-body rounded shadow col-md-8">
  <h4 class="pb-2 mb-0">Friend's invitations to events</h4>
</div>

<?php if($invitations):?>

  <ul class="list-group p-3 col-md-8 list-group-flush">
    <?php foreach($invitations as $event):?>
      <?php if(Utils::IsDateAfterNow($event->date)):?>
        <?php $invitation = $eventService->GetInvitation($event->id_event, $currentUser->id_user)?>
        <li class="row shadow rounded list-group-item d-flex mb-3 border mb-3 col-md-8">
          <div class="col">
            <i class="bi bi-calendar-event text-primary"></i>
            <span><?= date("F j, Y, g:i a", strtotime($event->date))?></span> 
            <strong class="d-block text-secondary"><?= $event->title?></strong>
            <span class="d-block fst-italic text-secondary"><?= $event->place?></span>
            <small class="d-block text-secondary mt-1"><?php echo count($eventService->GetInvitationsToEvent($event->id_event))?> people invited</small>

            <form action="../../app/controllers/eventInvitations/SendInvitationResponse.php" method="POST" class="mt-3">
              <input hidden name='idInvitation' value='<?= $invitation->id_invitation?>'>
              
              <div class="form-check form-check-inline my-2">
                <input class="form-check-input" type="radio" <?php if($invitation->status == 1) echo 'checked'?>  name='<?= 'radio_' . $invitation->id_invitation?>' id='<?= 'radio1_' . $invitation->id_invitation?>' value="1">
                <label class="form-check-label text-primary fw-bold" for='<?= 'radio1_' . $invitation->id_invitation?>'>Interested</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio"<?php if($invitation->status == 2) echo 'checked'?>  name='<?= 'radio_' . $invitation->id_invitation?>' id='<?= 'radio2_' . $invitation->id_invitation?>' value="2">
                <label class="form-check-label text-success fw-bold"  for='<?= 'radio2_' . $invitation->id_invitation?>'>Going</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" <?php if($invitation->status == 3) echo 'checked'?>  name='<?= 'radio_' . $invitation->id_invitation?>' id='<?= 'radio3_' . $invitation->id_invitation?>' value="3">
                <label class="form-check-label text-danger fw-bold" for='<?= 'radio3_' . $invitation->id_invitation?>'>Can't make it</label>
              </div>  
        
              <button type="submit" class="btn btn-secondary btn-sm">Send response</button>
            </form>

          </div>
        </li>
      <?php endif?>
    <?php endforeach?>

  </ul>
<?php else:?>
  <h5 class="lead my-5"><i class="bi bi-exclamation-diamond"></i>
    No event invitations</h5>
<?php endif?>
</main>


<?php
$layout->PrintFooter();
?>
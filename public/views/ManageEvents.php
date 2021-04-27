<?php
require_once __DIR__ . '/../../public/shared/Layout.php';
require_once __DIR__ . '/../../public/shared/Alert.php';
require_once __DIR__ . '/../../app/Utilities/authorization.php';
require_once __DIR__ . '/../../app/services/models/EventModelService.php';
require_once __DIR__ . '/../../app/services/models/UserModelService.php';

Authorization::Authorize();
$layout = new Layout();
$eventService = new EventModelService();
$userService = new UserModelService();
$layout->PrintHead();
$layout->PrintHeaderAuth();
Alert::PrintAlert('manageEventMessage');
$currentUser = $_SESSION['auth'];
?>
<main class="container-lefted mt-5">

<a href="./MyEvents.php" >Back to my events</a>

<?php if(isset($_GET['id']) && trim($_GET['id'])):?>
<?php
$idEvent = $_GET['id'];
$actualEvent = $eventService->GetEventById($idEvent);
?>

  <?php if($actualEvent != null):?>
  <?php $invitations = $eventService->GetInvitationsToEvent($actualEvent->id_event);?>

      <div class="my-3 p-3 bg-body rounded shadow col-md-8">
        <h4 class="pb-2 mb-0">Manage event invitations</h4>
      </div>


    <div class="my-3 p-3 bg-body rounded shadow col-md-8">

      <div class="mt-4">
        <h4 class="lead text-secondary fw-bolder">Event details:</h4>
      </div>

      <div class="mb-3 p-3 bg-body rounded shadow">
        <i class="bi bi-calendar-event text-primary"></i>
        <span><?= date("F j, Y, g:i a", strtotime($actualEvent->date))?></span> 
          <?php if(Utils::IsDateAfterNow($actualEvent->date)):?>
              <small class="text-success fw-bold ms-3">Active</small>
          <?php else:?>
              <small class="text-danger fw-bold ms-3">Expired</small>
          <?php endif?>
        <strong class="d-block text-secondary"><?= $actualEvent->title?></strong>
        <span class="d-block fst-italic text-secondary"><?= $actualEvent->place?></span>
        <small class="d-block text-secondary mt-1"><?php echo count($invitations)?> people invited</small>
      </div>

    <?php if(Utils::IsDateAfterNow($actualEvent->date)):?>
      <div class="mt-5">
        <h4 class="lead text-secondary fw-bolder">Invite a friend:</h4>
      </div>

      <div class="col-md-3">
        <form action="../../app/controllers/manageEvents/SendEventInvitation.php" method="POST">
          <div class="input-group mb-4">
            <input type="text" required class="form-control" name='username' placeholder="username">
            <input type="text" hidden class="form-control" name='idEvent' value='<?=$idEvent?>'>
            <button class="input-group-text btn btn-outline-success" type="submit"><i class="bi bi-person-plus"></i></button>
          </div>
        </form>
      </div>
    <?php endif?>


      <div class="mt-4">
        <h4 class="lead text-secondary fw-bolder">Invitation status:</h4>
      </div>

      <?php if($invitations):?>
        <ul class="list-group">
        <?php foreach($invitations as $invitation):?>
          <?php $user = $userService->TryGetById($invitation->id_invited);?>

          <li class="list-group-item border rounded mb-2">
            <a href='javascript:void(0)' data-id='<?= $invitation->id_invitation?>' data-page='' data-action='manageEvents/DeleteEventInvitation' class='text-danger link-delete'><i class="text-danger bi bi-trash-fill"></i></a> 
            <?= $user->first_name?> <?= $user->last_name?>
            <strong class="d-block text-secondary">@<?= $user->username?></strong>  
            
            <div class="form-check form-check-inline">
              <input class="form-check-input" onclick="return false;" type="radio" <?php if($invitation->status == 0) echo'checked'?>  name='<?= 'radio_' . $invitation->id_invitation?>' id='<?= 'radio0_' . $invitation->id_invitation?>' value="0">
              <label class="form-check-label text-secondary fw-bold" for='<?= 'radio0_' . $invitation->id_invitation?>'>No response</label>
            </div>  

            <div class="form-check form-check-inline my-2">
              <input class="form-check-input" onclick="return false;" type="radio" <?php if($invitation->status == 1) echo 'checked'?>  name='<?= 'radio_' . $invitation->id_invitation?>' id='<?= 'radio1_' . $invitation->id_invitation?>' value="1">
              <label class="form-check-label text-primary fw-bold" for='<?= 'radio1_' . $invitation->id_invitation?>'>Interested</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" onclick="return false;" type="radio"<?php if($invitation->status == 2) echo 'checked'?>  name='<?= 'radio_' . $invitation->id_invitation?>' id='<?= 'radio2_' . $invitation->id_invitation?>' value="2">
              <label class="form-check-label text-success fw-bold"  for='<?= 'radio2_' . $invitation->id_invitation?>'>Going</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" onclick="return false;" type="radio" <?php if($invitation->status == 3) echo 'checked'?>  name='<?= 'radio_' . $invitation->id_invitation?>' id='<?= 'radio3_' . $invitation->id_invitation?>' value="3">
              <label class="form-check-label text-danger fw-bold" for='<?= 'radio3_' . $invitation->id_invitation?>'>Can't make it</label>
            </div>  
            
          </li>
        <?php endforeach?>

        </ul>
      <?php else:?>
        <h5 class="lead my-5"><i class="bi bi-exclamation-diamond"></i>
          No friends invited</h5>
      <?php endif?>
    </div>

  <?php else:?>
    <h5 class="lead my-5"><i class="bi bi-exclamation-diamond"></i>
      No event found</h5>
  <?php endif?>

<?php else:?>
 <h5 class="lead my-5"><i class="bi bi-exclamation-diamond"></i>
  No event</h5>
<?php endif?>


</main>


<?php $layout->PrintFooter();?>
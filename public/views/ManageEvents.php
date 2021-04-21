<?php
require_once __DIR__ . '/../../public/shared/Layout.php';
require_once __DIR__ . '/../../public/shared/Alert.php';
require_once __DIR__ . '/../../app/Utilities/authorization.php';
require_once __DIR__ . '/../../app/services/models/FriendModelService.php';

Authorization::Authorize();
$layout = new Layout();
$friendService = new FriendModelService();
$layout->PrintHead();
$layout->PrintHeaderAuth();
Alert::PrintAlert('myEventMessage');
$currentUser = $_SESSION['auth'];
?>

<main class="container-lefted mt-5">

<a href="./MyEvents.php" >Back to my events</a>

<div class="my-3 p-3 bg-body rounded shadow col-md-8">
  <h4 class="pb-2 mb-0">Manage event invitations</h4>
</div>


<div class="my-3 p-3 bg-body rounded shadow col-md-8">

<div class="mt-4">
  <h4 class="lead text-secondary fw-bolder">Event details:</h4>
</div>

  <div class="mb-3 p-3 bg-body rounded shadow">
    <i class="bi bi-calendar-event text-primary"></i>
    <span>15/07/2021 15:00</span> <small class="text-danger ms-3">Expired</small>
    <strong class="d-block text-secondary">International Seminar on Pedagogical Approaches</strong>
    <span class="d-block fst-italic text-secondary">Fort Lauderdale, Florida</span>
    <small class="d-block text-secondary">12 people invited</small>
  </div>

  <div class="mt-5">
    <h4 class="lead text-secondary fw-bolder">Invite a friend:</h4>
  </div>

<div class="col-md-3">
  <form action="../../app/controllers/friends/AddFriend.php" method="POST">
    <div class="input-group mb-4">
      <input type="text" required class="form-control" name='username' placeholder="username">
      <button class="input-group-text btn btn-outline-success" type="submit"><i class="bi bi-person-plus"></i></button>
    </div>
  </form>
</div>


  <div class="mt-4">
    <h4 class="lead text-secondary fw-bolder">Invitation status:</h4>
  </div>
    <ul class="list-group">
    
      <li class="list-group-item border rounded mb-2">
        <a href=<?= '../../app/controllers/friends/RemoveFriend.php?id=' .  $friend->id_user?> ><i class="text-danger bi bi-trash-fill"></i></a> 
        Ruben Alonzo
        <strong class="d-block text-secondary">@TheBest</strong>  

        <div class="form-check form-check-inline">
          <input checked class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3">
          <label class="form-check-label text-secondary fw-bold" for="inlineRadio3">No response</label>
        </div>  

        <div class="form-check form-check-inline my-2">
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
        
      </li>
    
      <li class="list-group-item border rounded mb-2">
        <a href=<?= '../../app/controllers/friends/RemoveFriend.php?id=' .  $friend->id_user?> ><i class="text-danger bi bi-trash-fill"></i></a> 
        Ruben Alonzo
        <strong class="d-block text-secondary">@TheBest</strong>  

        <div class="form-check form-check-inline">
          <input checked class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3">
          <label class="form-check-label text-secondary fw-bold" for="inlineRadio3">No response</label>
        </div>  

        <div class="form-check form-check-inline my-2">
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
        
      </li>
    
      <li class="list-group-item border rounded mb-2">
        <a href=<?= '../../app/controllers/friends/RemoveFriend.php?id=' .  $friend->id_user?> ><i class="text-danger bi bi-trash-fill"></i></a> 
        Ruben Alonzo
        <strong class="d-block text-secondary">@TheBest</strong>  

        <div class="form-check form-check-inline">
          <input checked class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3">
          <label class="form-check-label text-secondary fw-bold" for="inlineRadio3">No response</label>
        </div>  

        <div class="form-check form-check-inline my-2">
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
        
      </li>


    </ul>
</div>




</main>


<?php
$layout->PrintFooter();
?>
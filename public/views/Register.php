<?php
require_once __DIR__ . '/../../public/shared/Layout.php';
require_once __DIR__ . '/../../public/shared/Alert.php';
require_once __DIR__ . '/../../app/controllers/RegisterController.php';

$layout = new Layout();
$layout->PrintHead('Register');
$layout->PrintHeaderNonAuth();
Alert::PrintAlert('registerMessage');
?>

<div class="col-md-6 mt-5 mx-auto">
   <div class="card">
      <div class="card-header">
         <span class="fw-bold fs-2">Register</span>
      </div>
      <div class="card-body">
         <form enctype="multipart/form-data" method="POST" action="../../app/controllers/RegisterController.php">
            <div class="row">
               <div class="col">
                  <div class="mb-3">
                     <label for="firstName" class="form-label">First name</label>
                     <input type="text" class="form-control" name="firstName" required>
                  </div>
                  <div class="mb-3">
                     <label for="lastName" class="form-label">Last name</label>
                     <input type="text" class="form-control" name="lastName" required>
                  </div>
                  <div class="mb-3">
                     <label for="phone" class="form-label">Phone number</label>
                     <input type="tel" 
                     pattern="(809|829|849)-[0-9]{3}-[0-9]{4}" 
                     placeholder="xxx-xxx-xxxx" 
                     class="form-control" 
                     name="phone" 
                     required>
                  </div>
                  <div class="mb-3">
                    <label for="profilePic" class="form-label">Profile picture</label>
                    <input class="form-control" type="file" name="profilePic" required>
                  </div>
               </div>
               <div class="col">
                  <div class="mb-3">
                     <label for="email" class="form-label">Email address</label>
                     <input type="email" class="form-control" name="email" required >
                  </div>
                  <div class="mb-3">
                     <label for="userName" class="form-label">Username</label>
                     <input type="text" class="form-control" name="userName" required>
                  </div>
                  <div class="mb-3">
                     <label for="password" class="form-label">Password</label>
                     <input type="password" class="form-control" name="password" required>
                  </div>
                  <div class="mb-3">
                     <label for="confirmPassword" class="form-label">Confirm password</label>
                     <input type="password" class="form-control" name="confirmPassword" required>
                  </div>
               </div>
            </div>
            <div class="d-grid gap-2 col-md-3 mx-auto my-2">
               <button class="btn btn-primary" type="submit">Register</button>
            </div>
         </form>
      </div>
      <div class="card-footer text-muted">
         It's free!
      </div>
   </div>
</div>

<?php
$layout->PrintFooter();
?>
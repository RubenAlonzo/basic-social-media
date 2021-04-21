<?php
require_once __DIR__ . '/../../public/shared/Layout.php';
require_once __DIR__ . '/../../public/shared/Alert.php';
require_once __DIR__ . '/../../app/Utilities/authorization.php';
require_once __DIR__ . '/../../app/database/DbContext.php';

$isLoggedIn = Authorization::CheckAuthStatus();

if($isLoggedIn) header("location: basic-social-media/../../../public/views/home.php");

$layout = new Layout();
$layout->PrintHead('Login');
$layout->PrintHeaderNonAuth();
Alert::PrintAlert('loginMessage');
?>

<div class="col-md-6 col-xl-3 mt-5 mx-auto">
  <div class="card shadow">
    <div class="card-header">
      <span class="fw-bold fs-2">Log in</span>
    </div>
    <div class="card-body">

      <form method="POST" action="../../app/controllers/account/Login.php">
        <div class="mb-3">
          <label for="userName" class="form-label">Username</label>
          <input type="text" class="form-control" name="userName" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" name="password" required>
        </div>
        <div class="d-grid gap-2 col-md-3 mx-auto mt-4">
          <button type="submit" class="btn btn-primary mb-3">Submit</button>
        </div>
      </form>
      <div class="text-center">
        
        <a href="./Register.php">Create an account</a>
        <a class="d-block" href="" data-bs-toggle="modal" data-bs-target="#forgotpwd" >Forgot password?</a>
      </div>
    </div>
    <div class="card-footer text-muted">
      It's free!
    </div>
  </div>
</div>



<?php
$layout->PrintFooter();
?>

  <!-- Reset password Modal -->
  <div class="modal fade" id="forgotpwd" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Reset password account</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
          <form action="../../app/controllers/account/ForgotPassword.php" method="POST">
            <div class="modal-body">
              <div class="mb-3">
                <label for="username" class="form-label">Enter your username account:</label>
                <input type="text" class="form-control" name="username" required >
              </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary float-end">Publish</button>
            </div>
          </form>
      </div>
    </div>
  </div>

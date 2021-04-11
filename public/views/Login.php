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

<div class="col-md-6 mt-5 mx-auto">
  <div class="card">
    <div class="card-header">
      <span class="fw-bold fs-2">Log in</span>
    </div>
    <div class="card-body">

      <form method="POST" action="../../app/controllers/account/LoginController.php">
        <div class="mb-3">
          <label for="userName" class="form-label">Username</label>
          <input type="text" class="form-control" name="userName" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary mb-3">Submit</button>
      </form>

      <a href="./Register.php">Create an account</a>
      <a href="#" class="d-block">Forgot Password?</a>
    </div>
    <div class="card-footer text-muted">
      It's free!
    </div>
  </div>
</div>

<?php
$layout->PrintFooter();
?>
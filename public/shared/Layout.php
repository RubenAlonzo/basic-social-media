<?php
class Layout{
  private $directoryUp;

  public function __construct($isRoot = false){
    $this->directoryUp = ($isRoot) ? "public/" : "../";
  }

  public function PrintHead($title = 'Social Media'){
    echo <<<EOF
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="{$this->directoryUp}assets/css/bootstrap/bootstrap.min.css">
      <link rel="stylesheet" href="{$this->directoryUp}assets/icons/bootstrap-icons.css">
      <link rel="stylesheet" href="{$this->directoryUp}assets/css/app.css">
      <title>{$title}</title>
    </head>
    <body>
EOF;
    }

  public function PrintHeaderNonAuth(){
    echo <<<EOF
    <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Main navigation">
      <div class="container-fluid container-lefted my-2">
        <a class="navbar-brand" href="./Home.php">Home</a>
        <button class="navbar-toggler p-0 border-0" type="button" data-bs-toggle="offcanvas" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
          <div class="d-flex">
          <a href="./Login.php" class="btn btn-primary me-2">Sign in</a>
          <a href="./Register.php" class="btn btn-success">Sign up</a>
          </div>
        </div> 
      </div>
    </nav>
  </header>
EOF;
    }

  public function PrintHeaderAuth($page = ""){
    switch ($page) {
      case 'friends':
        $friends = 'active';
        break;
      case 'events':
        $events = 'active';
        break;
      case 'notifications':
        $notifications = 'active';
        break;
    }
    echo <<<EOF
    <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Main navigation">
      <div class="container-fluid container-lefted my-2">
        <a class="navbar-brand" href="./Home.php">Home</a>
        <button class="navbar-toggler p-0 border-0" type="button" data-bs-toggle="offcanvas" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link {$friends}" href="./Friends.php">Friends</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {$events}" href="#">Events</a>
              <li class="nav-item">
                <a class="nav-link {$notifications}" href="#">Notifications <span class="badge bg-primary">4</span></a>
              </li>
            </li>
          </ul>
          <form class="d-flex" method="POST" action="../../app/controllers/account/Logout.php">
            <button class="btn btn-secondary" type="submit">Log out</button>
          </form>
        </div>
      </div>
    </nav>
  </header>
EOF;
    }
    
  function PrintFooter(){
    echo <<<EOF
    <footer class="text-muted py-5">
      <div class="container">
      <p class="mb-1">Ruben Alonzo | 2018-6966 © </p>
      </div>
      </footer>
      <script src="{$this->directoryUp}assets/scripts/bootstrap/bootstrap.min.js"></script>
      <script src="{$this->directoryUp}assets/scripts/jquery/jquery-3.5.1.min.js"></script>
      <script src="{$this->directoryUp}assets/scripts/index.js"></script>
      </body>
  </html>
EOF;
  }
}
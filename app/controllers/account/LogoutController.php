<?php
session_start();
$_SESSION['auth'] = ''; // Cleanup auth session rather than destroying them all
$_SESSION['loginMessage'] = ['You are now logged out, come back soon.', 'info'];
header('Location: ../../../public/views/login.php');
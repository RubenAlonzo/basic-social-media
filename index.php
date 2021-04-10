<?php
require_once __DIR__ . '/app/Utilities/authorization.php';
Authorization::Authorize(true);
// If it get here, that means the user has a auth session
header("location: basic-social-media/../public/views/home.php");
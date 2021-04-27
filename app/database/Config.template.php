<?php

// ********* IMPORTANT ********* 
// This is a configuration template
// Create a copy of this file called Config.php in app/database 

define("DB_HOST" , "localhost");
define("DB_NAME" , "social_media_20186966"); // This name comes from the DB script file

define("IMG_DATA_PATH" , __DIR__ . '/../../public/assets/img');
define("IMG_POST_PATH" , __DIR__ . '/../../public/assets/img/posts');
define("IMG_PROFILE_PATH" , __DIR__ . '/../../public/assets/img/profile');

// Set up constant below according to your enviroment

define("DB_USER" , "{your database user}");
define("DB_PASSWORD" , "{your database user password}");

define("MAIL_HOST" , "{your gmail account}");
define("MAIL_PWD" , "{your gmail password}");
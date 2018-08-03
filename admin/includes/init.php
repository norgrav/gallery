<?php

defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

//C:\wamp64\www\Udemy\OOPHP\gallery\admin

define('SITE_ROOT', DS . 'wamp64' . DS . 'wwww' . DS . 'Udemy' . DS . 'OOPHP' . DS . 'gallery');

defined('INCLUDES_PATH') ? null : define('INCLUDES_PATH', SITE_ROOT.DS . 'admin' . DS . 'includes');

require_once("functions.php");
require_once("new_config.php");
require_once("database.php");
require_once("db_object.php");
require_once("user.php");
require_once("class.photo.php");
require_once("session.php");
require_once("comment.php");
require_once("paginate.php");

?>
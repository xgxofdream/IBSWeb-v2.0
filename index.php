<?php 
session_start ();

include 'db/db_config.php';
include 'config/global.php';
include 'functions/function.php';

define("SERVER_ROOT", dirname(__FILE__));

define('SITE_ROOT' , 'http://localhost/');

/**
 * Introduce router.php to assign needs
 */
require_once(SERVER_ROOT . '/controllers/' . 'router.php');

?>

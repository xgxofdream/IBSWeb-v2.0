<?php 
session_start ();
/**
 * Introduce basic files
 */
include 'db/db_config.php';
include 'config/global.php';
include 'functions/function.php';
/**
 * Define ROOT level variables
 */
define("SERVER_ROOT", dirname(__FILE__));
define('SITE_ROOT' , 'http://localhost/');

/**
 * Introduce router.php to assign needs
 */
require_once(SERVER_ROOT . '/controllers/' . 'router.php');

?>

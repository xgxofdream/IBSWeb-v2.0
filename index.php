<?php 
session_start ();

include 'db/db_config.php';
include 'config/global.php';
include 'functions/function.php';
//应用的根目录就是index.php的父目录
define("SERVER_ROOT", dirname(__FILE__));

//你的域名.comm 是你的服务器域名
define('SITE_ROOT' , 'http://localhost/');

/**
 * 引入router.php
 */
require_once(SERVER_ROOT . '/controllers/' . 'router.php');

?>
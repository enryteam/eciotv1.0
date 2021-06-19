<?php
@session_start();
$_SESSION = array();
	if (ini_get("session.use_cookies")) {
		$params = session_get_cookie_params();
		
		setcookie(session_name(), '', time() - 42000,
		
		$params["path"], $params["domain"],
		
		$params["secure"], $params["httponly"]
		
		);
	}
/**
 * index.php 入口
 */
header("Content-type: text/html; charset=utf-8");
header("X-XSS-Protection: 1");
header("Cache-Control: no-cache");
// header('Access-Control-Allow-Origin:*');

define('APP_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('PHPFRAME_PATH', dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR);

include PHPFRAME_PATH . '/phpframe/base.php';
//error_reporting(0);
error_reporting(0);//DEBUG: E_ALL/0
pc_base::creat_app();
?>

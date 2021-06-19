<?php

    header("Content-type: text/html; charset=utf-8");
	header("X-XSS-Protection: 1");
	header("Cache-Control: no-cache");
	header("X-Content-Type-Options:nosniff");
	// header('Access-Control-Allow-Origin:*');
	@session_start();
	if (isset($_POST["login"]))
	{
			$link = mysql_connect("localhost", "eciot_open","eciot_open",  "7b275a31e7a1249abc0b42ccd086f134")
			or die("无法建立MySQL数据库连接：" . mysql_error());
			mysql_select_db("cms") or die("无法选择MySQL数据库");
		if (!get_magic_quotes_gpc())
		{
			$query = "select * from `eciot_admin` where user_name=’" . addslashes($_POST["username"]) ."’ and password=’" . addslashes($_POST["password"]) . "’";
		}
		else
		{
			$query = "select * from `eciot_admin` where user_name=’" . $_POST["username"] ."’ and password=’" . $_POST["password"] . "’";
		}
			$result = mysql_query($query)
			or die("执行MySQL查询语句失败：" . mysql_error());
			$match_count = mysql_num_rows($result);
		if ($match_count)
		{
			$_SESSION['admin_id'] = $match_count["admin_id"];
			$_SESSION['token'] = md5($match_count["admin_id"]);
			$_SESSION['admin_name'] = $match_count["user_name"];
			$_SESSION['real_name'] = $match_count["real_name"];
			$_SESSION["book"] = 1;
			mysql_free_result($result);
			mysql_close($link);
			// header("Location: http://localhost/index.php?user=" .$_POST["username"]);
		}
	}
	
	ini_set('memory_limit', '512M');

	define('APP_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
	define('ATTMS_PATH', APP_PATH . 'attms' . DIRECTORY_SEPARATOR);
	define('PHPFRAME_PATH', dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR);
	
	include PHPFRAME_PATH . '/phpframe/base.php';
	ini_set('session.use_cookies',1);
	ini_set('session.cookie_lifetime',999999);
	ini_set('session.gc_maxlifetime', 999999);
	set_time_limit(30);
	ini_set('date.timezone','Asia/Shanghai');
	date_default_timezone_set('Asia/Shanghai');
	error_reporting(0);
	pc_base::creat_app();

<?php
defined('IN_PHPFRAME') or exit('No permission resources.');
$session_storage = 'session_' . pc_base::load_config('system', 'session_storage');
pc_base::load_sys_class($session_storage);
pc_base::load_sys_class('controller');

/**
 * Protocol公共基类，构造方法
 *
 */
class protocol extends controller{

	public function __construct(){
		//
	
	}
	
	
	
}
<?php 
defined('IN_PHPFRAME') or exit('No permission resources.');
pc_base::load_app_class('BmsAction');

//规则引擎
class rules extends BmsAction {
  public function __construct() {
    parent::__construct();
  }
  public function nodered_editor() {
    header("location:http://".$_SERVER['SERVER_NAME'].":1880/");
    exit;
  }
  
}


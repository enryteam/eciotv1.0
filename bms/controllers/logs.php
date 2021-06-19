<?php
defined('IN_PHPFRAME') or exit('No permission resources.');
pc_base::load_app_class('BmsAction');

//日志中心
class logs extends BmsAction {

  private $model = null;

  public function __construct() {
    $model = D('Bms');
    $this->model = $model;
    parent::__construct();
  }

  //短信消息
  public function smsmsg() {
    parent::rule(__METHOD__);
    
    $this->display();
  }
  //服务消息
  public function mqttmsg() {
    parent::rule(__METHOD__);
    //打印../service/log/online_xxxx.log
    $this->display();
  }




}

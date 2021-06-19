<?php

defined('IN_PHPFRAME') or exit('No permission resources.');
import('@.libs.classes.BaseAction');

class BmsAction extends BaseAction {

  public function __construct() {
    @session_start();
    $pageSize = intval(getgpc('pageSize'));
    if ($pageSize) {
      $_SESSION['pageSize'] = $pageSize;
    } else {
      if (!$_SESSION['pageSize']) {
        $_SESSION['pageSize'] = 10;
      }
    }
    if (!$_SESSION['admin_id']) {
      if (getgpc('c') == 'index') {
        if (getgpc('a') <> 'login' && getgpc('a') <> 'dologin') {
          header('Location:./index.php?c=index&a=login');
          exit;
        }
      } else {
        if (getgpc('c') <> 'upfile') {
          header('Location:./index.php?c=index&a=login');
        }
      }
    }
  }
  //后台鉴权
  public function rule($action) {
    $model = D('Bms');
    $admin = $model->queryone('select gid from `eciot_admin` where admin_id = ' . $_SESSION['admin_id']);
    $dolog=$model->queryone("select * from `eciot_admin_log` where loginip='".$_SERVER["REMOTE_ADDR"]."' order by id desc ");
      D('Bms')->querysql("INSERT INTO `eciot_admin_log`(`admin_id`, `admin_name`, `loginip`, `ctime`, `action`, `content`) VALUES ('" . $_SESSION['admin_id'] . "','" . $_SESSION['admin_name'] . "','" . $_SERVER["REMOTE_ADDR"] . "','" . date('Y-m-d H:i:s') . "','" . $action . "','" . $content . "')");
    $user_quanxian = $model->queryone('select * from `eciot_admin_group` where id = ' . $admin['gid']);
    $rule = explode(',', $user_quanxian['rules']);
    if (!in_array($action, $rule)) {
      bmsAlertGoBack("您没有此操作权限");
      die;
    }
  }
  
 
}

<?php

defined('IN_PHPFRAME') or exit('No permission resources.');
pc_base::load_app_class('BmsAction');
//用户信息
class admininfo extends BmsAction {
  private $model = null;
  public function __construct() {
    $model = D('Bms');
    $this->model = $model;
    parent::__construct();
  }
  /**插入&修改个人信息操作
   * 
   */
  public function edit() {
    $model = $this->model;
    if (isPost()) {
      parent::rule(__METHOD__);
      //获取要插入的数据
      $real_name = getgpc('real_name');
      $phone = getgpc('phone');
      $qq = getgpc('qq');
      $wechat = getgpc('wechat');
      $addr = getgpc('addr');
      $card_id = getgpc('card_id');
      $photo = getgpc('photo');
      //如果有id存在，则修改信息 			
      $sql = "update `eciot_admin` set real_name='" . $real_name . "',phone='" . $phone . "',qq='" . $qq . "',wechat='" . $wechat . "',addr='" . $addr . "',card_id='" . $card_id . "',photo = '" . $photo . "' where token = '" . $_SESSION['token']."'";
      $rs = $model->querysql($sql);
      if ($rs) {
        bmsAlert('修改成功', pfUrl('', 'admininfo', 'edit'));
      } else {
        bmsAlert('修改失败', pfUrl('', 'admininfo', 'edit'));
      }
    } else {
      $sql = "select * from `eciot_admin` where is_del=0 and token='" . $_SESSION['token']."'";
      $rs = $model->queryone($sql);
      $detail = $rs;
      if ($detail) {
        $this->assign('details', $detail);
      }
      $this->display();
    }
  }

  /**修改密码
   */
  public function change_pwd() {
    $model = $this->model;
    if (isPost()) {
      parent::rule(__METHOD__);
      $old_pwd = getgpc('old_password');
      $new_pwd = getgpc('password1');
      $sql = "select * from `eciot_admin` where is_del=0 and admin_id=" . $_SESSION['admin_id'];
      $rs = $model->queryone($sql);
      if($rs['password']==md5(md5(trim($old_pwd) . '@eciot_open'))){
        $sql = "update `eciot_admin` set password = '" . md5(md5(trim($new_pwd) . '@eciot_open')) . "'  where token = '". $_SESSION['token']."'";
        $re = $model->querysql($sql);
        if ($re) {
          bmsAlert("修改成功", pfUrl(null, "admininfo", "change_pwd"));
        } else {
          bmsAlert("修改失败", pfUrl(null, "admininfo", "change_pwd"));
        }
      }else{
        bmsAlert("原密码错误", pfUrl(null, "admininfo", "change_pwd"));
      }
    } else {
      $this->display();
    }
  }
}
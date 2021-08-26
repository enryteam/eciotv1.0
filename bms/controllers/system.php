<?php

defined('IN_PHPFRAME') or exit('No permission resources.');
pc_base::load_app_class('BmsAction');

//系统
class system extends BmsAction {

  private $model = null;

  public function __construct() {
    $model = D('Bms');
    $this->model = $model;
    parent::__construct();
  }
  ////////////////////////      系统  start           ////////
 
  //管理员列表
  public function admin_index() {
    parent::rule(__METHOD__);
    $model = $this->model;
    $page_size = $_SESSION["pageSize"];
    $page = max(getgpc('page'), 1);
    $count = $model->count("`eciot_admin`");
    $arr = $model->query("select * from `eciot_admin` limit " . ($page - 1) * $page_size . "," . $page_size);
    //p($arr);
    foreach ($arr as $ke => $vo) {
      $r = $model->queryone("select * from `eciot_admin_group` where id='" . $vo['gid'] . "' ");
      $arr[$ke]['roles'] = $r['title'];
    }
    $this->assign('re', $arr);
    $pages = pages_layer($count, $page, $page_size, '', $search);
    $this->assign('pages', $pages);
    $this->assign('search', $search);
    $this->display();
  }

  public function admin_add() {
    parent::rule(__METHOD__);
    $model = $this->model;
    if (isPost()) {
      $user_name = getgpc('user_name');
      $real_name = getgpc('real_name');
      $admin_id = getgpc('admin_id');
      $department_id=getgpc("department_id");
      $password = trim(getgpc('password'));
      $is_del = getgpc('is_del');
      $gid = getgpc('gid'); 
      if (!$admin_id) {
        $password = md5(md5(trim(getgpc('password')) . '@eciot_open'));
        $re = $model->queryone("select * from `eciot_admin` where user_name='" . $user_name . "'");
        if ($re) {
          returnJson('500', '管理员账号已存在');
        }
        $res = $model->querysql("INSERT INTO `eciot_admin`(`user_name`, `real_name`, `password`,`gid`) VALUES ('$user_name','$real_name','$password','$gid')");
        if ($res) {
          returnJson('200', '添加成功');
        } else {
          returnJson('500', '添加失败');
        }
      } else {
        $re = $model->queryone("select * from `eciot_admin` where user_name='" . $user_name . "' and admin_id<> '$admin_id' ");
        if ($re) {
          returnJson('500', '管理员账号已存在');
        }
        $r = $model->queryone("select * from `eciot_admin` where admin_id= '$admin_id'");
        if ($password != $r['password']) {
          $password = md5(md5(trim(getgpc('password')) . '@eciot_open'));
        }
        $res = $model->querysql("update `eciot_admin` set `user_name`='$user_name', `real_name`='$real_name', `password`='$password',`gid`='$gid', `is_del`='$is_del' where  admin_id='$admin_id'");
        if ($res) {
          returnJson('200', '编辑成功');
        } else {
          returnJson('500', '编辑失败');
        }
      }
    }
    $admin_id = getgpc('admin_id');
    $admin = $model->queryone("select * from `eciot_admin` where admin_id='" . $admin_id . "'");
    $this->assign('detail', $admin);
    $res = $model->query("select * from `eciot_admin_group`");
    $this->assign('res', $res);
    $cate=$model->query("select * from `eciot_department` ");
    $cate_all=$this->getChildren($cate,0);
    $this->assign('cate',$cate_all);
    $this->display();
  }
  //删除 管理员
  public function admin_remove() {
    parent::rule(__METHOD__);
    $model = $this->model;
    $admin_id = getgpc('admin_id');
    $r = $model->queryone("select * from `eciot_admin` where admin_id='" . $admin_id . "'");
    if ($r) {
      $re = $model->querysql("delete from `eciot_admin` where admin_id='" . $admin_id . "'");
      if ($re) {
        header("Location:" . pfUrl('', 'system', 'admin_index'));
      } else {
        bmsAlert('操作失败', pfUrl('', 'system', 'admin_index'));
      }
    } else {
      bmsAlert('参数错误', pfUrl('', 'system', 'admin_index'));
    }
  }
}

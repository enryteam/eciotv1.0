<?php

defined('IN_PHPFRAME') or exit('No permission resources.');
pc_base::load_app_class('BmsAction');
header("Content-type: text/html; charset=utf-8");

class index extends BmsAction {

  private $model = null;

  public function __construct() {
    $model = D('Bms');
    $this->model = $model;
    $_SESSION['pageSize']=10;
    parent::__construct();
  }

  //默认
  public function index() {
    $model = $this->model;
    $rules = $model->queryone("select * from `eciot_admin_group` where status=1 and id='" . $_SESSION['gid'] . "'");
    $rule = explode(',', $rules['rules']);
    $arr = array();
    foreach ($rule as $k => $v) {
      $r = $model->queryone("select * from `eciot_admin_side_action` where module='" . $v . "' ");
      $arr[] = $r['id'];
    }
    $arr = array_unique($arr);
    $arr = array_filter($arr);
    $ids = implode(',', $arr);
    $this->assign('ids', $ids);
    if(!$ids){
      header('Location:./index.php?c=index&a=login');
       exit;
    }
    //最后添加权限的时候用到的数据--不可删除  and id in($ids)
    $re = $model->query("select * from `eciot_admin_side_action` where fid=0 and is_show=1  order by sore asc ");
    foreach ($re as $key => $vo) {
      $sql = "select * from `eciot_admin_side_action` where fid='".$vo['id']."' and is_show=1  order by sore asc";
      $res = $model->query($sql);
      if($res){
        $re[$key]['lists'] = $res;
      }else{
        $re[$key]['lists'] = false;
      }
    }
    $this->assign('re', $re);
    //权限列表
    $this->display();
  }

  //控制台
  public function console() {
    $menu_arr = array();
    $menu = D('Bms')->query('select * from eciot_admin_side_action where fid=0 and id>1 order by sore asc');
    foreach ($menu as $key => $value) {
      $menu_son = D('Bms')->query('select * from eciot_admin_side_action where fid='.$value['id'].'  and is_show=1 order by sore asc');
      $menu_arr[] = array("menu"=>$value,"son"=>$menu_son);
    }
    $this->assign('menu',$menu_arr);
    $this->display();
  }
  
  //登录页面
  public function login() {
    //载入模板
    $this->display();
  }

  //登录处理
  public function dologin() {
    $model = $this->model;
    $sql = "select * from `eciot_admin` where is_del = 0 and  user_name = '" . getgpc("user_name") . "'  and password = '" . md5(md5(trim(getgpc('pass_word')) . '@eciot_open')) . "'";
    $rst = $model->queryone($sql);
    if ($rst) {
      $_SESSION['admin_id'] = $rst["admin_id"];
      $_SESSION['token'] = md5($rst["admin_id"]);
      $_SESSION['admin_name'] = $rst["user_name"];
      $_SESSION['real_name'] = $rst["real_name"];
      $_SESSION['gid'] = $rst["gid"];
      $_SESSION['school_id'] = $rst["school_id"];
      $sql="update `eciot_admin` set token='".md5($rst["admin_id"])."' where user_name='".$rst["user_name"]."'";
      $model->querysql($sql);
      $sql = "insert into `eciot_bmslogin` (uid,time,ip) values('" . $rst["admin_id"] . "','" . date('Y-m-d H:i:s') . "','" . trim($_SERVER["REMOTE_ADDR"]) . "')";
      $model->querySql($sql);
      $model->querysql("INSERT INTO `eciot_admin_log`(`admin_id`, `admin_name`, `loginip`, `ctime`, `action`, `content`) VALUES ('" . $_SESSION['admin_id'] . "','" . $_SESSION['admin_name'] . "','" . $_SERVER["REMOTE_ADDR"] . "','" . date('Y-m-d H:i:s') . "','index::dologin','登录')");
      
      returnJson('200', '登陆成功');
    } else {
      returnJson('500', '账号或密码错误');
    }
  }

  //退出
  public function logout() {
    unset($_SESSION['admin_id']);
    unset($_SESSION['admin_name']);
    unset($_SESSION['real_name']);
    unset($_SESSION['gid']);
    bmsAlert("退出成功", pfUrl("bms", "index", "login"));
  }

}

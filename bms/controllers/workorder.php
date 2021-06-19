<?php

defined('IN_PHPFRAME') or exit('No permission resources.');
pc_base::load_app_class('BmsAction');

class workorder extends BmsAction {

  private $model = null;

  public function __construct() {
    $model = D('Bms');
    $this->model = $model;
    parent::__construct();
  }
  //工单配置
  public function flow(){
    parent::rule(__METHOD__);
    $model=$this->model;
    $page_size = $_SESSION['pageSize'];
    $page = max(getgpc('page'), 1);
    $sql="select * from  eciot_workorder_user ";
    $count=$model->ecount($sql);
    $res=$model->query($sql ." order by id desc limit " . ($page - 1) * $page_size . "," . $page_size);
    $this->assign('lists',$res);
    $pages = pages_layer($count, $page, $page_size, '', $search);
    $this->assign('search', $search);
    $this->display();
  }

  //工单配置 编辑
  public function flow_edit(){
    parent::rule(__METHOD__);
    $model=$this->model;
    if(isPost()){
      $id=getgpc('id');
      $user_id=getgpc('user_id');
      $remark=getgpc('remark');
      $user=$model->queryone("select * from eciot_department_user where id='".$user_id."'");
      $ctime=date('Y-m-d H:i:s');
      if(!$id){
        $sql="INSERT INTO `eciot_workorder_user`(`user_id`, `user_name`, `phone`, `openid`, `remark`, `ctime`) VALUES ('".$user_id."','".$user['user_name']."','".$user['phone']."','".$user['openid']."','".$remark."','".$ctime."') ";
      }else{
        $sql="update `eciot_workorder_user` set user_id='".$user_id."',user_name='".$user['user_name']."',phone='".$user['phone']."',openid='".$user['openid']."',remark='".$remark."' where id='".$id."'";
      }
      $res=$model->querysql($sql);
      if($res){
        returnJson('200','编辑成功');
      }else{
        returnJson('500','编辑失败');
      }
    }else{
      $id=getgpc('id');
      $re=$model->queryone("select * from `eciot_workorder_user` where id='".$id."'");
      $this->assign('details',$re);
      $user=$model->query("select * from `eciot_department_user`");
      $this->assign("user",$user);
    }
    $this->display();
  }

  //工单配置删除
  public function flow_remove(){
    parent::rule(__METHOD__);
    $model=$this->model;
    $id=getgpc('id');
    $re=$model->queryone("select * from `eciot_workorder_user` where id='".$id."'");
    if($re){
      $r=$model->querysql("delete from `eciot_workorder_user` where id='".$id."'");
      if($r){
        header("Location:".pfUrl('','workorder','flow'));
      }else{
        bmsAlert('删除失败',pfUrl('','workorder','flow'));
      }
    }else{
      bmsAlert('参数错误',pfUrl('','workorder','flow'));
    }
  }

  //未处理的工单
  public function todo(){
    parent::rule(__METHOD__);
    $model = $this->model;
    $page_size = $_SESSION['pageSize'];
    $page = max(getgpc('page'), 1);
    $terminal_name=getgpc('terminal_name');
    $is_device=getgpc('is_device');
    // $type=getgpc('type');
    $status=getgpc('status');
    $sql = "select * from `eciot_gateway_workorder` where status in (1,2) " ;
    if($terminal_name){
      $search['terminal_name']=$terminal_name;
      $r=$model->query("select id,name from eciot_gateway_terminal where name like '%".$terminal_name."%'");
      $ar=array();
      foreach($r as $k=>$v){
        $ar[]=$v["id"];
      }
      $ids=implode(',',$ar);
      $sql .=" and  terminal_id in ($ids)";
    }
    if($is_device){
      $search['is_device']=$is_device;
      $sql .=" and is_device='".$is_device."' ";
    }
    if($status){
      $search['status']=$status;
      $sql .=" and status='".$status."' ";
    }
    $count=$model->ecount($sql);
    $res = $model->query($sql ." order by id desc limit " . ($page - 1) * $page_size . "," . $page_size);
    foreach ($res as $key => $vo) {
      $sql="select a.name as product_name,a.id as product_id,b.id as terminal_id,b.name as terminal_name from eciot_product a , eciot_gateway_terminal b where a.id=b.product_id and b.id='".$vo['terminal_id']."' ";
      $product=$model->queryone($sql);
      $res[$key]['product_name']=$product['product_name'];
      $res[$key]['terminal_name']=$product['terminal_name'];
      $user=$model->queryone("select * from `eciot_department_user` where id='".$vo['assign_id']."'");
      $res[$key]['assign_name']=$user['user_name'];
      $admin=$model->queryone("select * from `eciot_admin` where admin_id='".$vo['admin_id']."'");
      $res[$key]['admin_name']=$admin['user_name'];

    }
    $this->assign('lists', $res);
    $pages = pages_layer($count, $page, $page_size, '', $search);
    $this->assign('search', $search);
    $user=$model->query("select * from `eciot_department_user` ");
    $this->assign("user",$user);
    $this->display();
  }

  //todo 指派
  public function todo_lists(){
    parent::rule(__METHOD__);
      $model=$this->model;
      $user_id=getgpc('user_id');
      $ids=getgpc('terminal_ids');
      if(!$user_id){
        returnJson('500','请选择指派成员');
      }
      if(!$ids){
        returnJson('500','请勾选维修工单');
      }
      $terminal=$model->query("select * from `eciot_gateway_workorder` where terminal_id in ($ids) and status in(1,2) ");
      foreach($terminal as $ke=>$vo){
          $re=$model->querysql("update `eciot_gateway_workorder` set admin_id='".$_SESSION['admin_id']."',assign_id='".$user_id."',status=2,assign_time='".date('Y-m-d H:i:s')."' where id='".$vo['id']."' ");
      }
      if($re){
        returnJson('200','指派成功');
      }else{
        returnJson('500','指派失败');
      }

  }

  //已处理的工单
  public function done(){
    parent::rule(__METHOD__);
    $model = $this->model;
    $page_size = $_SESSION['pageSize'];
    $page = max(getgpc('page'), 1);
    $terminal_name=getgpc('terminal_name');
    $is_device=getgpc('is_device');
    // $type=getgpc('type');
    $status=getgpc('status');
    $sql = "select * from `eciot_gateway_workorder` where status in (3) " ;
    if($terminal_name){
      $search['terminal_name']=$terminal_name;
      $r=$model->query("select id,name from eciot_gateway_terminal where name like '%".$terminal_name."%'");
      $ar=array();
      foreach($r as $k=>$v){
        $ar[]=$v["id"];
      }
      $ids=implode(',',$ar);
      $sql .=" and  terminal_id in ($ids)";
    }
    if($is_device){
      $search['is_device']=$is_device;
      $sql .=" and is_device='".$is_device."' ";
    }
    if($status){
      $search['status']=$status;
      $sql .=" and status='".$status."' ";
    }
    $count=$model->ecount($sql);
    $res = $model->query($sql ." order by id desc limit " . ($page - 1) * $page_size . "," . $page_size);
    foreach ($res as $key => $vo) {
      $sql="select a.name as product_name,a.id as product_id,b.id as terminal_id,b.name as terminal_name from eciot_product a , eciot_gateway_terminal b where a.id=b.product_id and b.id='".$vo['terminal_id']."' ";
      $product=$model->queryone($sql);
      $res[$key]['product_name']=$product['product_name'];
      $res[$key]['terminal_name']=$product['terminal_name'];
      $user=$model->queryone("select * from `eciot_department_user` where id='".$vo['assign_id']."'");
      $res[$key]['assign_name']=$user['user_name'];
      $admin=$model->queryone("select * from `eciot_admin` where admin_id='".$vo['admin_id']."'");
      $res[$key]['admin_name']=$admin['user_name'];
    }
    $this->assign('lists', $res);
    $pages = pages_layer($count, $page, $page_size, '', $search);
    $this->assign('search', $search);
    $user=$model->query("select * from `eciot_department_user` ");
    $this->assign("user",$user);
    $this->display();
  }


  //设备告警工单
  public function warn() {
    parent::rule(__METHOD__);
    $model = $this->model;
    $page_size = $_SESSION['pageSize'];
    $page = max(getgpc('page'), 1);
    $terminal_name=getgpc('terminal_name');
    $is_device=getgpc('is_device');
    // $type=getgpc('type');
    $status=getgpc('status');
    $sql = "select * from `eciot_gateway_workorder` where type=2" ;
    if($terminal_name){
      $search['terminal_name']=$terminal_name;
      $r=$model->query("select id,name from eciot_gateway_terminal where name like '%".$terminal_name."%'");
      $ar=array();
      foreach($r as $k=>$v){
        $ar[]=$v["id"];
      }
      $ids=implode(',',$ar);
      $sql .=" and  terminal_id in ($ids)";
    }
    if($is_device){
      $search['is_device']=$is_device;
      $sql .=" and is_device='".$is_device."' ";
    }
    if($status){
      $search['status']=$status;
      $sql .=" and status='".$status."' ";
    }
    $count=$model->ecount($sql);
    $res = $model->query($sql ." order by id desc limit " . ($page - 1) * $page_size . "," . $page_size);
    foreach ($res as $key => $vo) {
      $sql="select a.name as product_name,a.id as product_id,b.id as terminal_id,b.name as terminal_name from eciot_product a , eciot_gateway_terminal b where a.id=b.product_id and b.id='".$vo['terminal_id']."' ";
      $product=$model->queryone($sql);
      $res[$key]['product_name']=$product['product_name'];
      $res[$key]['terminal_name']=$product['terminal_name'];
      $user=$model->queryone("select * from `eciot_department_user` where id='".$vo['assign_id']."'");
      $res[$key]['assign_name']=$user['user_name'];
      $admin=$model->queryone("select * from `eciot_admin` where admin_id='".$vo['admin_id']."'");
      $res[$key]['admin_name']=$admin['user_name'];
    }
    $this->assign('lists', $res);
    $pages = pages_layer($count, $page, $page_size, '', $search);
    $this->assign('search', $search);
    $user=$model->query("select * from `eciot_department_user` ");
    $this->assign("user",$user);
    $this->display();
  }

  //工单维修
  public function repair() {
    parent::rule(__METHOD__);
    $model = $this->model;
    $page_size = $_SESSION['pageSize'];
    $page = max(getgpc('page'), 1);
    $terminal_name=getgpc('terminal_name');
    $is_device=getgpc('is_device');
    // $type=getgpc('type');
    $status=getgpc('status');
    $sql = "select * from `eciot_gateway_workorder` where type=1" ;
    if($terminal_name){
      $search['terminal_name']=$terminal_name;
      $r=$model->query("select id,name from eciot_gateway_terminal where name like '%".$terminal_name."%'");
      $ar=array();
      foreach($r as $k=>$v){
        $ar[]=$v["id"];
      }
      $ids=implode(',',$ar);
      $sql .=" and  terminal_id in ($ids)";
    }
    if($is_device){
      $search['is_device']=$is_device;
      $sql .=" and is_device='".$is_device."' ";
    }
    if($status){
      $search['status']=$status;
      $sql .=" and status='".$status."' ";
    }
    $count=$model->ecount($sql);
    $res = $model->query($sql ." order by id desc limit " . ($page - 1) * $page_size . "," . $page_size);
    foreach ($res as $key => $vo) {
      $sql="select a.name as product_name,a.id as product_id,b.id as terminal_id,b.name as terminal_name from eciot_product a , eciot_gateway_terminal b where a.id=b.product_id and b.id='".$vo['terminal_id']."' ";
      $product=$model->queryone($sql);
      $res[$key]['product_name']=$product['product_name'];
      $res[$key]['terminal_name']=$product['terminal_name'];
      $user=$model->queryone("select * from `eciot_department_user` where id='".$vo['assign_id']."'");
      $res[$key]['assign_name']=$user['user_name'];
      $admin=$model->queryone("select * from `eciot_admin` where admin_id='".$vo['admin_id']."'");
      $res[$key]['admin_name']=$admin['user_name'];
    }
    $this->assign('lists', $res);
    $pages = pages_layer($count, $page, $page_size, '', $search);
    $this->assign('search', $search);
    $user=$model->query("select * from `eciot_department_user` ");
    $this->assign("user",$user);
    $this->display();
  }


  



}

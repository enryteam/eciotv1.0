<?php

defined('IN_PHPFRAME') or exit('No permission resources.');
pc_base::load_app_class('BmsAction');

class building extends BmsAction {

  private $model = null;

  public function __construct() {
    $model = D('Bms');
    $this->model = $model;
    
    parent::__construct();
  }
  
  
  public function getChildren($arr,$id=0){
      static $array=array();
      foreach($arr as $ke=>$vo){
          if($vo['fid']==$id){
              $array[]=$vo;
              $this->getChildren($arr,$vo['id']);
          }
      }
      return $array;
  }

  //建筑物--首页
  public function index() {
    parent::rule(__METHOD__);
    $model = $this->model;
    $sql = "select * from `eciot_building` order by id desc  " ;
    $count=$model->ecount($sql);
    $buildings = $model->query($sql);
    foreach ($buildings as $key => $vo) {
         $re=$model->queryone("select * from `eciot_building` where id='".$vo['fid']."'");
         $buildings[$key]['cate_title']=$re['name'];
         $r=$model->queryone("select * from `eciot_gateway` where id='".$vo['gateway_id']."'");
         $buildings[$key]['sn']=$r['sn'];
    }
    $this->assign('lists', $buildings);
    $pages = pages_layer($count, $page, $page_size, '', $search);
    $this->assign('search', $search);
    $this->display();
  }

  //建筑物--修改
  public function edit() {
    parent::rule(__METHOD__);
    $model = $this->model;
    $id = getgpc('id');
    if (isPost()) {
        $id=getgpc('id');
      $name = getgpc('name');
      $type_id = getgpc('type_id');
      $fid=getgpc('fid');
      $area = getgpc('area');
      $describe = getgpc('describe');
      $gateway_id=getgpc('gateway_id');
      if($fid>0){
          $re=$model->queryone("select * from `eciot_building` where id='".$fid."'");
          if($re){
              $num=$re['num']+1;
          }else{
              $num=1;
          }
      }else{
          $num=1;
      }
      if ($id) {
        $sql = "UPDATE `eciot_building` SET `gateway_id`='".$gateway_id."',`type_id`='" . $type_id . "',`fid`='".$fid."',`num`='".$num."',`name`='" . $name . "',`area1`='" . $area . "',`describe`='" . $describe . "' WHERE id = " . $id;
      } else {
         $sql = "INSERT INTO `eciot_building`(`school_id`,`gateway_id`, `type_id`,`fid`,`num`, `name`, `area1`, `describe`) VALUES ('" . $_SESSION['choose_sid'] . "','".$gateway_id."','" . $type_id . "','".$fid."','".$num."','" . $name . "','" . $area . "','" . $describe . "')";
      }
      $res = $model->querySql($sql);
      if ($res) {
        //$this->gateways($_SESSION['choose_sid']);
        returnJson('200', '编辑成功');
      } else {
        returnJson('500', '编辑失败');
      }
    }
    if ($id) {
      $sql = "SELECT * FROM `eciot_building` where id = " . $id;
      $detail = $model->queryone($sql);
      $this->assign('detail', $detail);
    }
   
    //查询区域无限分类
    $cate=$model->query("select * from `eciot_building` ");
    $cate_all=$this->getChildren($cate,0);
    $this->assign('cate',$cate_all);
    //查询网关
    $gateway=$model->query("select * from `eciot_gateway` order by id desc  ");
    $this->assign('gateway',$gateway);
    $this->display();
  }

  //建筑物--删除
  public function remove() {
    parent::rule(__METHOD__);
    $model = $this->model;
    $id = getgpc('id');
    $sql = "delete from `eciot_building` where id = " . $id;
    $rs = $model->querysql($sql);
    if ($rs) {
        header("Location:".pfUrl(null, "building", "index"));
    } else {
      bmsAlert("删除失败", pfUrl(null, "building", "index"));
    }
  }

  
}

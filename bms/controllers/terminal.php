<?php

defined('IN_PHPFRAME') or exit('No permission resources.');
pc_base::load_app_class('BmsAction');

class terminal extends BmsAction {

  private $model = null;

  public function __construct() {
    $model = D('Bms');
    $this->model = $model;
    
    parent::__construct();
  }
  //设备首页
  public function terminal_index() {
    parent::rule(__METHOD__);
    $model = $this->model;
    $page_size = $_SESSION['pageSize'];
    $page = max(getgpc('page'), 1);
    $gateway_id = getgpc('gateway_id');
    $this->assign('gateway_id', $gateway_id);
    $sql = "SELECT * FROM";
    $sql_res = " `eciot_gateway_terminal` WHERE 1=1";
    if($type_id){
      $search['type'] = $type_id;
      $sql_res .= " and type_id = $type_id";
    }
    if($gateway_id){
      $search['gateway_id'] = $gateway_id;
      $sql_res .= " and gateway_id = $gateway_id";
    }
    $count = $model->count($sql_res);
    $sql_res .= " order by id desc";
    $arr = $model->query($sql.$sql_res . " limit " . ($page - 1) * $page_size . "," . $page_size);
    foreach ($arr as $key => $vo) {
      $type = $model->queryone("SELECT * FROM `eciot_product` where id = ".$vo['product_id']);
      $arr[$key]['product_name'] = $type['name'];
      $gateway = $model->queryone("SELECT * FROM `eciot_gateway` where id = ".$vo['gateway_id']);
      $arr[$key]['gateway_name'] = $gateway['sn'];
	 
    }
    $this->assign('lists', $arr);
    $pages = pages_layer($count, $page, $page_size, '', $search);
    $this->assign('pages', $pages);
    $this->assign('search', $search);
    $gateway=$model->query("select * from `eciot_gateway` where is_online=1 ");
    $this->assign('gateway',$gateway);
    $this->display();
  }

  //新增/修改设备
  public function terminal_edit() {
    parent::rule(__METHOD__);
    $model = $this->model;
    $id = intval(getgpc('id'));
	$sn_code = create_randomstr(10);
	$this->assign('sn',$sn_code);
    if (isPost()) {
      $name = getgpc("name");
      $addr = getgpc("addr");
      $sn = getgpc("sn");
      $product_id = getgpc("product_id");
      $gateway_id = intval(getgpc('gateway_id'));
      $fault = getgpc("fault");
      if ($id) {
        
        $sql = "update `eciot_gateway_terminal` set name='" . $name . "',addr='" . $addr . "',sn='" . $sn . "',product_id='" . $product_id . "',gateway_id='".$gateway_id."' where id = " . $id;
        $rs = $model->querysql($sql);
      } else {
        $topic = create_randomstr(10);
        $sql = "INSERT INTO `eciot_gateway_terminal`( `gateway_id`,`name`, `addr`, `sn`, `product_id`, `ctime`) VALUES ('" . $gateway_id . "','" . $name . "','" . $addr . "','" . $sn . "','" . $product_id . "','" . time() . "')";
        $rs = $model->querysql($sql);
      }
      if ($rs) {
        returnJson('200','操作成功',array('gateway_id'=>$gateway_id));
        bmsAlert('操作成功', pfUrl('', 'terminal', 'terminal_index',array('gateway_id'=>$gateway_id)));
      } else {
        returnJson('200','操作失败');
        bmsAlert('操作失败', pfUrl('', 'terminal', 'terminal_index',array('gateway_id'=>$gateway_id)));
      }
    }
    if ($id > 0) {
      $sql = "select * from `eciot_gateway_terminal` where id= " . $id;
      $rs = $model->queryone($sql);
      if ($rs) {
        $this->assign('details', $rs);
      }
    }
    $sql = "SELECT * FROM `eciot_product`";
    $type = $model->query($sql);
    if ($type) {
      $this->assign('type', $type);
    }
    //网关设备
    $gateway=$model->query("select * from `eciot_gateway` ");
     $this->assign('gateway', $gateway);
    $this->display();
  }
  //无限递归
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
	//设备禁用
	public function terminal_remove(){
            parent::rule(__METHOD__);
            $model=$this->model;
            $id=getgpc('id');
            $is_disable=getgpc('is_disable');
            $re=$model->queryone("select * from `eciot_gateway_terminal` where id='".$id."'");
            if($re){
                $r=$model->querysql("update `eciot_gateway_terminal` set is_disable='".$is_disable."' where id='".$id."'");
                if($r){
                    header("Location:".pfUrl('','terminal','terminal_index'));
                }else{
                    bmsAlert('操作失败',pfUrl('','terminal','terminal_index'));
                }
            }else{
                bmsAlert('参数错误',pfUrl('','terminal','terminal_index'));
            }
	}
    //用于 debug 弹窗
    public function lists(){
        $model=$this->model;
        $id=getgpc('id');
        $product_id=getgpc('product_id');
        //产品的事件
        $event=$model->query("select * from `eciot_product_state` where product_id='".$product_id."'");
        $this->assign('event',$event);
        //设备流水最新几条数据
        //先查询 设备的 sn  在查设备的 最新几条流水
        $re=$model->queryone("select * from `eciot_gateway_terminal` where id='".$id."'" );
        $this->assign('re',$re);
        //查流水
        $arr=$model->query("select * from `eciot_product_".$product_id."` where sn= '".$re['sn']."' order by id desc ");
        //查询表结构 
        $rer=$model->query("show FULL columns from `eciot_product_".$product_id. "`");
        $this->assign('rer',$rer);
        $arr_lists=$model->query("select * from  `eciot_product_".$product_id. "` where terminal_id='".$id."' order by id desc limit 5 ");
        $this->assign('arr_lists',$arr_lists);
        $this->display();
    }

    //GET请求
    public function getback($url) {
      $ch = curl_init();
      $timeout = 5;
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
      $file_contents = curl_exec($ch);
      curl_close($ch);
      return $file_contents;
    }

    //设备操作
    public function state_edit() {
      parent::rule(__METHOD__);
      $model=$this->model;
      $terminal_id = getgpc('terminal_id');
      $state_id = getgpc('state_id');
      $terminal = $model->queryone("SELECT * FROM `eciot_gateway_terminal` WHERE id = '" . $terminal_id . "'");
      $product=$model->queryone("select * from `eciot_product` where id='".$terminal['product_id']."' ");
      //查询协议
      $protocol=$model->queryone("select * from `eciot_protocol` where protocol_id='".$product['protocol_id']."'");
      $filephp=substr($protocol['protocol_script'],0,-4);
      $url=$_SERVER ['HTTP_HOST']."/protocol/index.php?c=".$filephp."&a=msg_encode&terminal_id=".$terminal_id."&state_id=".$state_id."&protocol_id=".$product['protocol_id'];
      echo $this->getback($url);
    }

   

}

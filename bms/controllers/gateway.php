<?php
defined('IN_PHPFRAME') or exit('No permission resources.');
pc_base::load_app_class('BmsAction'); 
//网关
class gateway extends BmsAction {
  private $model = null;
  public function __construct() {
    $model = D('Bms');
    $this->model = $model;
    parent::__construct();
  }

  //网关首页
  public function index() {
    parent::rule(__METHOD__);
    $model = $this->model;
    $page_size = $_SESSION['pageSize'];
    $page = max(getgpc('page'), 1);
  
    $sql = "SELECT * FROM `eciot_gateway`  " ;
    $count = $model->ecount($sql);
    $sql .= " order by id desc";
    $arr = $model->query($sql . " limit " . ($page - 1) * $page_size . "," . $page_size);
    $this->assign('lists', $arr);
    $pages = pages_layer($count, $page, $page_size, '', $search);
    $this->assign('pages', $pages);
    $this->assign('search', $search);
   
    $this->display();
  }
  
//新增/修改网关
  public function gateway_edit() {
    //parent::rule(__METHOD__);
    $model = $this->model;
    $id = intval(getgpc('id'));
    if (isPost()) {
		$id = getgpc("id");
                $company_code=getgpc('company_code');
                $project_code=getgpc('project_code');
		$sn = getgpc("sn");
		$type = getgpc("type");
                $up_topic=getgpc('up_topic');
		$client_id = create_randomstr(20);
      if ($id) {
        $sql = "update eciot_gateway set company_code='".$company_code."',project_code='".$project_code."',sn='" . $sn . "',type='" . $type . "',`client_id`='".$client_id."',up_topic='".$up_topic."',is_reg=1 where id = " . $id;
        $rs = $model->querysql($sql);
		if ($rs) {
			bmsAlert('修改成功', pfUrl('', 'gateway', 'index'));
		  } else {
			bmsAlert('操作失败', pfUrl('', 'gateway', 'index'));
		  }
      } else {
        $topic = create_randomstr(10);
        $sql = "INSERT INTO `eciot_gateway`(`sn`, `type`, `company_code`,`project_code`, `client_id`, `topic`,`up_topic`,`ctime`) VALUES ('" . $sn . "','" . $type . "','".$company_code."','".$project_code."','" .$client_id . "','" . $topic . "','".$up_topic."','".date('Y-m-d H:i:s')."')";
        $rs = $model->querysql($sql);
        if ($rs) {
              bmsAlert('操作成功', pfUrl('', 'gateway', 'index'));
        } else {
              bmsAlert('操作失败', pfUrl('', 'gateway', 'index'));
        }
      }
      
    }
    
    if ($id > 0) {
      $sql = "select * from eciot_gateway where id= " . $id;
      $rs = $model->queryone($sql);
      if ($rs) {
        $this->assign('details', $rs);
      }	
    }
    $this->display();
  }


  //删除网关
  public function remove(){
	$model=$this->model;
	$gateway_id = getgpc('gateway_id');
	$re=$model->queryone("select * from eciot_gateway where id='".$gateway_id."'");
	if($re){
		$res=$model->querysql("delete from eciot_gateway where id='".$gateway_id."'");
		if($res){
			//bmsAlert('操作成功', pfUrl('', 'gateway', 'index'));
			header("location:".pfUrl('', 'gateway', 'index'));
			die;
		}else{
			bmsAlert('操作失败', pfUrl('', 'gateway', 'index'));
		}
	}else{
		bmsAlert('参数错误', pfUrl('', 'gateway', 'index'));
	}
  }
  
  //网关注册与取消
  public function gateway_reg(){
    $model=$this->model;
    $gateway_id=getgpc('gateway_id');
    $is_reg=getgpc('is_reg');
    $re=$model->queryone("select * from eciot_gateway where id ='".$gateway_id."'");
    if($re){
      $r=$model->querysql("update eciot_gateway set is_reg='".$is_reg."' where id='".$gateway_id."'");
      if($r){
        header("Location:".pfUrl('','gateway','index'));
      }else{
        bmsAlert('操作失败',pfUrl('','gateway','index'));
      }
    }else{
      bmsAlert('参数错误',pfUrl('','gateway','index'));
    }

  }


}

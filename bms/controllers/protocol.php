<?php
defined('IN_PHPFRAME') or exit('No permission resources.');
pc_base::load_app_class('BmsAction');

//协议管理
class protocol extends BmsAction {

  private $model = null;

  public function __construct() {
    $model = D('Bms');
    $this->model = $model;
    parent::__construct();
  }

  //协议首页
  public function index() {
    parent::rule(__METHOD__);
    $model = $this->model;
    $page_size = $_SESSION['pageSize'];
    $page = max(getgpc('page'), 1);
    $id = getgpc('protocol_id');
    $pro_name=getgpc("pro_name");
    $sql = "SELECT * FROM  `eciot_protocol` WHERE 1=1 ";
    if($id){
      $search['protocol_id'] = $id;
      $sql .= " and protocol_id ='". $id."' ";
    }
    if($pro_name){
        $search['pro_name'] = $pro_name;
        $sql .= " and protocol_name  like '%".$pro_name."%' ";
    }
    $count = $model->ecount($sql);
    $sql .= "  order by protocol_id desc";
    $arr = $model->query($sql . " limit " . ($page - 1) * $page_size . "," . $page_size);
    $this->assign('lists', $arr);
    $pages = pages_layer($count, $page, $page_size, '', $search);
    $this->assign('pages', $pages);
    $this->assign('search', $search);
    $res=$model->query("select * from `eciot_protocol` order by protocol_id desc ");
    $this->assign('res',$res);
    $this->display();
  }

  //新增/修改协议
  public function edit() {
    parent::rule(__METHOD__);
      $model=$this->model;
      if(isPost()){
          $id=getgpc("protocol_id");
          $name=getgpc('protocol_name');
          $script=getgpc("protocol_script");
          $publish=getgpc('protocol_publish');
          $remark=getgpc('protocol_remark');
          $ctime=date('Y-m-d H:i:s');
          if(!$id){
               $sql="INSERT INTO `eciot_protocol`(`protocol_name`, `protocol_script`, `protocol_publish`, `protocol_ctime`, `protocol_remark`) VALUES ('".$name."','".$script."','".$publish."','".$ctime."','".$remark."')";
          }else{
              $sql="update `eciot_protocol` set protocol_name='".$name."',protocol_script='".$script."',protocol_publish='".$publish."',protocol_remark='".$remark."' where protocol_id='".$id."'";
          }
          $re=$model->querysql($sql);
          if($re){
              returnJson('200','操作成功');
          }else{
              returnJson('500','操作失败');
          }
      }
       $id=getgpc("protocol_id");
      $detail=$model->queryone("select * from `eciot_protocol` where protocol_id='".$id."'");
      $this->assign('details',$detail);
        $this->display();
  }
  
    //删除协议
    public function protocol_remove(){
        exit;// by enry
        $model=$this->model;
        $id=getgpc("protocol_id");
        $re=$model->queryone("select * from `eciot_protocol` where protocol_id='".$id."' ");
        if($re){
            $r=$model->querysql("delete from  `eciot_protocol`  where protocol_id='".$id."'");
            if($r){
                header("location:" .pfUrl('','protocol','index'));
                die;
            }else{
                bmsAlert('删除失败',pfUrl('','protocol','index'));
            }
        }else{
            bmsAlert('参数错误',pfUrl('','protocol','index'));
        }
    }
    
    /// 发布与禁用
    public function protocol_start(){
        parent::rule(__METHOD__);
        $model=$this->model;
        $id=getgpc('protocol_id');
        $publish=getgpc('publish');
        $re=$model->queryone("select * from `eciot_protocol` where protocol_id='".$id."'");
        if($re){
            if($publish==0){
                $r=$model->queryone(" select * from `eciot_product` where protocol_id='".$id."' ");
                if($r){
                    bmsAlert('此协议有产品正在使用不可禁用', pfUrl(null,'protocol','index'));
                }
            }
            $r=$model->querysql("update `eciot_protocol` set protocol_publish='".$publish."' where protocol_id='".$id."'");
            if($r){
                 header("Location:" . pfUrl(null,'protocol','index'));
                 die;
            }else{
                bmsAlert('操作失败', pfUrl(null,'protocol','index'));
            }
        }else{
            bmsAlert('参数错误', pfUrl(null,'protocol','index'));
        }
    }
}
<?php
defined('IN_PHPFRAME') or exit('No permission resources.');

pc_base::load_app_class('RestAction');
error_reporting(E_ALL);
class workorder_encode extends RestAction
{
  
    private $appid;
		private $sessionKey;
		private $model = null;
		private $week = null;
		private $path = null;

	public function __construct()
	{
		parent::__construct();
    $model = D('Rest');
    $this->model = $model;
		$this->path = '../attms/upfile/'.date("Y").'/'.date("m").'/'.date("d").'/'.date("H").'/';
		mk_dir($this->path);
	}
  /*
  请求方式：get
  入参：url
  */ 
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

  public function wendu(){
    $model = $this->model;
    $res=$model->query("select * from eciot_product_16 ");
    foreach($res as $ke=>$vo){  
       $wendu=str_replace("°C","",$vo['wendu']);
      echo  $wendu=$wendu."°C";
      echo "\r\n";
       $model->querysql("update eciot_product_16 set wendu='".$wendu."' where id='".$vo['id']."'");
    }

  }


  /*
  * 无限分类
  */
  public function getChildren($arr,$fid=0){
    static $array=array();
    foreach($arr as $ke=>$vo){
        if($vo['id']==$fid){
            $array[]=$vo;
            $this->getChildren($arr,$vo['fid']);
        }
    }
    return $array;
}

  /*
    协议类型：gateway_mqtt_subscribe_workorder
    消息编码: 订阅网关消息去创建工单
    入参：设备ID、状态ID ...
    消息提醒：根据工单流程发送EC_IOT公众号/106短信给对应人员
  */
  public function order() {
      $model = $this->model;

      ///TODO 
      $gateway_id=getgpc("gateway_id");
      $sn_type=getgpc("type");
      $terminal_id=getgpc("terminal_id");
      //查询所有设别故障 或报警处理
      if($terminal_id && $sn_type==1){
        //设备故障 开始创建工单
        $type=1; //  1 维修 2 报警
        $r=$model->queryone("select * from `eciot_gateway_workorder` where terminal_id='".$terminal_id."' and status<3  ");
        if($r){
          $smscode=$model->queryone("select * from `eciot_smscode` order by id desc");
          $terminal=$model->queryone("select * from eciot_gateway_terminal where id='".$terminal_id."'");
          $build=$model->queryone("select * from `eciot_building` where id='".$terminal['building_id']."'");
          $res=$model->query("select * from `eciot_building` ");
          $arr_all=$this->getChildren($res,$build['fid']);
          $count=count($arr_all);
          $lists_all=array();
          $j=1;
          for($i=0;$i<$count;$i++){
            $j=$count-$j;
            $lists_all[]=$arr_all[$j];
            $j++;
          }
          $arr_name='';
          foreach($lists_all as $ke=>$vo){
            $arr_name.=$vo['name']."-";
          }
          $arr_name=$arr_name.$build['name'];
          if($terminal){
            $user=$model->query("select * from eciot_department_user where is_service=1 and is_del=0");
            $title=$terminal['name']."故障报修";
            $content=$terminal['name']."故障工单内容";
            foreach($user as $ke=>$vo){
              ///////短信推送
              $url = 'http://utf8.api.smschinese.cn/?Uid='.$smscode['sms_uid'].'&Key='.$smscode['sms_key'].'&smsMob=' . $vo['phone'] . '&smsText=' . $content . '';
              $ret = $this->getback($url);
              $arr=array();
              $arr['datatime']=date('Y-m-d H:i:s');
              $arr['title']=$title;
              $arr['content']=$content;
              file_put_contents('../service/log/sms_'.date("Ymd").'.log',"\r\n".date('YmdHis')."==".$arr_name."=设备故障==设备名称:".$terminal['name']."====="."\r\n".json_encode($arr),FILE_APPEND);
              if($ret==1){
                returnJson('200', '发送成功');
              }else{
                returnJson('500', '发送失败');
              }
            }
          }
        }
  }else if($gateway_id && $sn_type==2){
    //网关故障 开始创建工单
    $type=1; //  1 维修 2 报警
        $r=$model->queryone("select * from `eciot_gateway_workorder` where terminal_id='".$gateway_id."' and status<3 ");
        if(!$r){
          $smscode=$model->queryone("select * from `eciot_smscode` order by id desc");
          $gateway=$model->queryone("select * from eciot_gateway where id='".$gateway_id."'");
         if($gateway){
            $user=$model->query("select * from eciot_department_user where is_service=1 and is_del=0");
            $title="网关".$gateway['sn']."故障报修";
            $content="网关".$gateway['sn']."故障报修";
            foreach($user as $ke=>$vo){
              //短信推送
              $url = 'http://utf8.api.smschinese.cn/?Uid='.$smscode['sms_uid'].'&Key='.$smscode['sms_key'].'&smsMob=' . $phone . '&smsText=' . $content . '';
              $ret = $this->getback($url);
              $arr=array();
              $arr['datatime']=date('Y-m-d H:i:s');
              $arr['title']=$title;
              $arr['content']=$content;
              file_put_contents('../service/log/sms_'.date("Ymd").'.log',"\r\n".date('YmdHis')."==".$gateway['sn']."==网关故障==网关ID:".$gateway_id."==="."\r\n".json_encode($arr),FILE_APPEND);
              if($ret==1){
                returnJson('200', '发送成功');
              }else{
                returnJson('500', '发送失败');
              }
            }
          }
        }
    }
  }
}

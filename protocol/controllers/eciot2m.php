<?php
defined('IN_PHPFRAME') or exit('No permission resources.');
pc_base::load_app_class('ProtocolAction');

class eciot2m extends ProtocolAction {

  private $model = null;

  public function __construct(){
    parent::__construct();
    $model = D('Protocol');
    $this->model = $model;

    //检查协议状态
    $sql = "SELECT * FROM `eciot_protocol` WHERE protocol_script = 'eciot2m.php'";
    $res = $this->model->queryone($sql);
    if($res['protocol_publish']<>'1')
    {
      returnJson('403', '协议未发布');
    }
  }
  //检查协议脚本
  public function index() {
    returnJson('200', '协议脚本可运行');
  }

  /*
  协议类型：gateway_mqtt_subscribe
  消息解码:网关发消息到平台 信息采集
  */
  public function msg_decode(){
    returnJson('403', '后台运行中...');
  }
  /*
  协议类型：gateway_mqtt_publish
  消息编码:平台发消息到网关 单控指令下达
  入参：设备ID、状态ID、状态名
  */
  public function msg_encode(){
    $model = $this->model;
    $arr_res = array();
    $terminal_id = getgpc('terminal_id');//设备ID
    $state_id = getgpc('state_id');//事件ID
    $name = getgpc('name');//状态名
    $terminal = $model->queryone("SELECT * FROM `eciot_gateway_terminal` WHERE id = '" . $terminal_id . "'");
    $gateway = $model->queryone("SELECT * FROM `eciot_gateway` WHERE id = '" . $terminal['gateway_id'] . "'");
    $product = $model->queryone("SELECT * FROM `eciot_product` where id=".$terminal['product_id']);
    $product_natures = $model->query("SELECT * FROM `eciot_product_nature` where product_id=".$terminal['product_id']." order by id asc");
    if($gateway['is_online']==0)
    {
      returnJson('403', '网关ID'.$terminal['gateway_id'].'离线', '连接网关异常 gateway-id-'.$terminal['gateway_id'].' offline......');
    }
    if(empty($product_natures))
    {
      returnJson('500', '缺少操作参数','变量异常 product_nature');
    }
    if($name){
      $state = $model->queryone("SELECT * FROM `eciot_product_state` where `name` = '" . $name . "' and product_id = " . $terminal['product_id']);
    }elseif($state_id){
      $state = $model->queryone("SELECT * FROM `eciot_product_state` where id = " . $state_id . " and product_id = " . $terminal['product_id']);
    }else{
      returnJson('500', '缺少操作参数');
    }
    if ($state) {
      //有结果说明操作正确
      $res = $model->querySql("UPDATE `eciot_gateway_terminal` SET `state`='".$state['id']."' WHERE id = $terminal_id");
      if ($res) {
        //数据表操作成功   下面通过mqtt操作设备
        require_once("../phpframe/plugin/mqtt/phpMQTT.php");
        $server = $gateway['server'];
        $port = $gateway['port'];
        $username = $gateway['username'];
        $password = $gateway['password'];
        $client_id = create_randomstr(10);
        $mqttConfig = include_once("../configs/mosquitto.php");
        $mqtt = new Bluerhinos\phpMQTT($mqttConfig['default']['server'], $mqttConfig['default']['port'], 'eciot3s_'.time());
        $mqtt->debug = $mqttConfig['default']['debug'];
        if ($mqtt->connect(true, NULL, $mqttConfig['default']['username'], $mqttConfig['default']['password'])) {
          $topic = 'DOWNDATA/'.$gateway['company_code'].'_'.$gateway['project_code'].'/' . $gateway['sn'];
          $arr = array();
          $arr['EntityNo'] = $gateway['company_code'].'_'.$gateway['project_code'];
          $arr['DeviceNo'] = $gateway['sn']; 
          $arr['Idx'] = md5(time());
          $arr['Func'] = "6";
          $status = json_decode($state['content'], true);
          $arr['Body'][0]['Module'] = 'thingtype_'.$product['thingtype'];
          $arr['Body'][0]['Status'] = 1;
          foreach($product_natures as $nature_val){
            foreach($status as $kkk=>$vvv)
            {
              if($kkk==$nature_val['nature']){
                $arr['Body'][0]['Reg_Val'][$nature_val['nature']] = $vvv;
              }
              else 
              {
                $arr['Body'][0]['Reg_Val'][$nature_val['nature']] = $nature_val['default_value'];
              }
              if($nature_val['type']=='float')
              {
                $arr['Body'][0]['Reg_Val'][$nature_val['nature']] = sprintf("%.".$nature_val['nature_float']."f",$arr['Body'][0]['Reg_Val'][$nature_val['nature']]);
              }
              elseif($nature_val['type']=='int')
              {
                $arr['Body'][0]['Reg_Val'][$nature_val['nature']] = intval($arr['Body'][0]['Reg_Val'][$nature_val['nature']]);
              }
              else 
              {
                $arr['Body'][0]['Reg_Val'][$nature_val['nature']] = $arr['Body'][0]['Reg_Val'][$nature_val['nature']];
              }
            }
          }
          $msg = json_encode($arr);
          $mqtt->publish($topic, $msg, 0);
          $mqtt->close();
          returnJson('200', '操作成功', $arr);
        } else {
          returnJson('500', '操作失败','连接异常 mqtt');
        }
      } else {
        returnJson('500', '操作失败','更新异常 terminal');
      }
    } else {
      returnJson('500', '操作失败','事件异常 product_state');
    }
    
  }
  /*
  协议类型：gateway_mqtt_publish
  消息编码:平台发消息到网关 群控指令下达
  入参：区域ID、产品ID
  */
  public function building_gateway_terminal(){
    $model = $this->model;
    $product_id = getgpc('product_id');//产品ID
    $state_id = getgpc('state_id');//状态ID
    $name = getgpc('name');//状态名
    $building_id = getgpc('building_id');//区域ID

    $terminalArr = $model->query("SELECT * FROM `eciot_gateway_terminal` WHERE building_id = '" . $building_id . "' and product_id='".$product_id."'");
    if($terminalArr)
    {
      foreach($terminalArr as $terminal){
        $terminal_id = $terminal['id'];//设备ID 
        $arr_res = array();
        $terminal = $model->queryone("SELECT * FROM `eciot_gateway_terminal` WHERE id = '" . $terminal_id . "'");
        $gateway = $model->queryone("SELECT * FROM `eciot_gateway` WHERE id = '" . $terminal['gateway_id'] . "'");
        $product = $model->queryone("SELECT * FROM `eciot_product` WHERE id = '" . $terminal['product_id'] . "'");
        $product_natures = $model->query("SELECT * FROM `eciot_product_nature` where product_id=".$terminal['product_id']." order by id asc");
        if($gateway['is_online']==0)
        {
          returnJson('403', '网关ID'.$terminal['gateway_id'].'离线', '连接网关异常 gateway-id-'.$terminal['gateway_id'].' offline......');
        }
        if($name){
          $state = $model->queryone("SELECT * FROM `eciot_product_state` where name = '" . $name . "' and product_id = " . $terminal['product_id']);
        }elseif($state_id){
          $state = $model->queryone("SELECT * FROM `eciot_product_state` where id = " . $state_id . " and product_id = " . $terminal['product_id']);
        }else{
          returnJson('500', '缺少操作参数');
        }
        if ($state) {
          //有结果说明操作正确
          $res = $model->querySql("UPDATE `eciot_gateway_terminal` SET `state`='".$state['id']."' WHERE id = $terminal_id");
          if ($res) {
            //数据表操作成功   下面通过mqtt操作设备
            require_once("../phpframe/plugin/mqtt/phpMQTT.php");
            $server = $gateway['server'];
            $port = $gateway['port'];
            $username = $gateway['username'];
            $password = $gateway['password'];
            $client_id = create_randomstr(10);
            $mqttConfig = include_once("../configs/mosquitto.php");
        $mqtt = new Bluerhinos\phpMQTT($mqttConfig['default']['server'], $mqttConfig['default']['port'], 'eciot3s_'.time());
        $mqtt->debug = $mqttConfig['default']['debug'];
        if ($mqtt->connect(true, NULL, $mqttConfig['default']['username'], $mqttConfig['default']['password'])) {
              $topic = 'DOWNDATA/'.$gateway['company_code'].'_'.$gateway['project_code'].'/' . $gateway['sn'];
              $arr = array();
              $arr['EntityNo'] = $gateway['company_code'].'_'.$gateway['project_code'];
              $arr['DeviceNo'] = $gateway['sn']; 
              $arr['Idx'] = md5(time());
              $arr['Func'] = "6";
              $status = json_decode($state['content'], true);
              $arr['Body'][0]['Module'] = 'thingtype_'.$product['thingtype'];
              $arr['Body'][0]['Status'] = 1;
              foreach($product_natures as $nature_val){
                foreach($status as $kkk=>$vvv)
                {
                  if($kkk==$nature_val['nature']){
                    $arr['Body'][0]['Reg_Val'][$nature_val['nature']] = $vvv;
                  }
                  else 
                  {
                    $arr['Body'][0]['Reg_Val'][$nature_val['nature']] = $nature_val['default_value'];
                  }
                  if($nature_val['type']=='float')
                  {
                    $arr['Body'][0]['Reg_Val'][$nature_val['nature']] = sprintf("%.".$nature_val['nature_float']."f",$arr['Body'][0]['Reg_Val'][$nature_val['nature']]);
                  }
                  elseif($nature_val['type']=='int')
                  {
                    $arr['Body'][0]['Reg_Val'][$nature_val['nature']] = intval($arr['Body'][0]['Reg_Val'][$nature_val['nature']]);
                  }
                  else 
                  {
                    $arr['Body'][0]['Reg_Val'][$nature_val['nature']] = $arr['Body'][0]['Reg_Val'][$nature_val['nature']];
                  }
                }
              }
              $msg = json_encode($arr);
              $mqtt->publish($topic, $msg, 0);
              $mqtt->close();
              returnJson('200', '操作成功', $arr);
            } else {
              returnJson('500', '操作失败','连接异常 mqtt');
            }
          } else {
            returnJson('500', '操作失败');
          }
        } else {
          returnJson('500', '参数异常');
        }
      }
      returnJson('200', '操作成功');
    }
    else 
    {

      returnJson('403', '该区域暂无该产品类型设备');
    }
  }

}

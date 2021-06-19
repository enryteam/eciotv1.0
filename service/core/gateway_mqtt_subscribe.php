<?php
  /*
  crontab 每15秒执行一次
  gateway_mqtt_subscribe
  消息解码:网关发消息到平台 信息采集
  */
error_reporting(0);
//文件锁
$file_lock="/eciot/htdocs/service/lock/gateway_mqtt_subscribe.lock";
if(file_exists($file_lock)){
    echo '正在执行请稍后····';
    die;
}else{
    file_put_contents($file_lock,time());
}
include_once("/eciot/htdocs/phpframe/plugin/mqtt/phpMQTT.php");
include_once('/eciot/htdocs/service/core/db.init.php');

//加载所有网关子设备的产品功能脚本
$sql = "SELECT p.id as product_id,t.protocol_script as protocol_script FROM `eciot_product` p,`eciot_protocol` t WHERE p.protocol_id = t.protocol_id and p.is_connect = 2";
$productArr = query($sql,$conn);
if(count($productArr)>0){
    foreach($productArr as $product){        
        include_once("/eciot/htdocs/protocol/scripts/eciot_product_".$product['product_id'].".php");
    }    
}
// 消息处理函数
function procmsg($topic, $msg)
{
    global $conn;
    global $productArr;
    $title = explode('/', $topic);
    $gateway=array();
    if(!empty($title[3])&&strpos('@'.$topic,'gateway/up/property/'))//eciot-3S主题识别
    {
        $sql = "SELECT * FROM `eciot_gateway` WHERE topic = '".$title[3]."'";
        $gateway = queryone($sql,$conn);
        $sql = "update `eciot_gateway` set is_online=1,heartbeat_time='".date('Y-m-d H:i:s')."' WHERE topic='".$title[3]."'";//网关心跳-上线
        querysql($sql,$conn);
    }
    if(!empty($title[2])&&strpos('@'.$topic,'UPDATA/'))//eciot-2M主题识别
    {
        $sql = "SELECT * FROM `eciot_gateway` WHERE sn = '".$title[2]."'";
        $gateway = queryone($sql,$conn);
        $sql = "update `eciot_gateway` set is_online=1,heartbeat_time='".date('Y-m-d H:i:s')."' WHERE sn='".$title[2]."'";//网关心跳-上线
        querysql($sql,$conn);
    }
    var_dump(array('TOPIC'=>$topic,'TITLE'=>$title,'GATEWAY'=>$gateway));
    //如查到网关则处理相关业务 
    
    if($gateway){
        //解析promsg
        $arr = array();
        $_arr = array();
        $_arr = json_decode($msg, true);
        if($gateway['type']=='eciot-3s')
        {
            $arr=$_arr;
        }
        if($gateway['type']=='eciot-2M')
        {
            $arr['timestamp']=$_arr['DateTime'];
            $arr['params']=$_arr['Body'][0]['Reg_Val'];
            foreach($_arr['Body'][0]['Reg_Val'] as $vkey=>$vrow){
                if(strpos('@'.$vkey,'TerminalSN_'))//须在M2网关的变量设置自定义这个别名
                {
                    $arr['sn']=str_replace('TerminalSN_','',$vkey);
                    break;
                }
            }
        }
        
        if($arr){
            
            $sql="select * from `eciot_gateway_terminal` where gateway_id='".$gateway['id']."'  and is_disable=1 ";
            $terminal_all=query($sql,$conn);
            $sql = "SELECT * FROM `eciot_gateway_terminal` WHERE gateway_id=".$gateway['id']." and is_disable=1  and sn = '".$arr['sn']."'";
            $terminal = queryone($sql,$conn);
            if($terminal_all){
                
                if(!$terminal){
                    
                    foreach($terminal_all as $ke=>$vo){
                        if($arr['sn']==$vo['sn']){
                            $sql="update `eciot_gateway_terminal` set online=2,fault=2 where id='".$vo['id']."'";
                            querysql($sql,$conn);
                            //故障上报
                            $sql="select * from `eciot_gateway_workorder` where terminal_id='".$vo['id']."' and status<3 ";
                            $r=queryone($sql,$conn);
                            if(!$r){
                                //没有工单开始创建
                                $sql="INSERT INTO `eciot_gateway_workorder`(`terminal_id`, `status`,`is_device`,`ctime`, `type`) VALUES ('".$vo['id']."',1,1,'".date('Y-m-d H:i:s')."','1')";
                                $re=querysql($sql,$conn);
                                $url="http://".$_SERVER['SERVER_NAME']."/rest/index.php?c=workorder_encode&a=order&terminal_id=".$vo['id']."&type=1";
                                $ch = curl_init();
                                $timeout = 5;
                                curl_setopt($ch, CURLOPT_URL, $url);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                                $file_contents = curl_exec($ch);
                                curl_close($ch);
                            }
                        }
                    }
                }else{
                    
                    foreach($terminal_all as $ke=>$vo){
                        if($terminal['sn']==$vo['sn']){
                            
                            $sql = "update `eciot_gateway_terminal` set fault=1, online=1 WHERE  sn = '".$vo['sn']."'";
                            querysql($sql,$conn);
                            //动态调用脚本中功能函数
                            if(count($productArr)>0){
                                
                                foreach($productArr as $product){
                                    if($terminal['product_id']==$product['product_id']){
                                        
                                        $function = "eciot_product_".$product['product_id'];
                                        var_dump(array('FUNCTION'=>$function,'GATEWAY'=>$gateway,'PROMSG'=>$arr));
                                        if (is_callable($function)) {
                                            var_dump('FUNCTION ... SUCC......');
                                            call_user_func($function, $conn,$gateway,$terminal,$arr);
                                            @file_put_contents('/eciot/htdocs/service/log/promsg_'.date("Ymd").'.log',date('YmdHis')."===FUNCTION IS ".$function."===\n".json_encode($arr)."\r\n",FILE_APPEND);
                                        }
                                        else 
                                        {
                                            var_dump('FUNCTION ... FAIL......');
                                            @file_put_contents('/eciot/htdocs/service/log/promsg_'.date("Ymd").'.log',date('YmdHis')."===FUNCTION NOT IS CALLABLE===\n".json_encode($arr)."\r\n",FILE_APPEND);

                                        }
                                        
                                    }
                                }    
                            }
                            
                        }
                    }
                }
            }    

        }
    }
} 
// 随机函数	
function create_randomstr($len = 6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    mt_srand(10000000*(double)microtime());
    for ($i = 0, $str = '', $lc = strlen($chars)-1; $i < $len; $i++){
    $str .= $chars[mt_rand(0, $lc)];
    }
    return $str;
}

//在线网关订阅响应过程
$sql = "SELECT * FROM `eciot_gateway` WHERE is_online = 1 order by id asc";
$gatewayArr = query($sql,$conn);
if(count($gatewayArr)>0)
{
    @file_put_contents('/eciot/htdocs/service/log/promsg_'.date("Ymd").'.log',date('YmdHis')."===========================gatewayArr====\n".var_export($gatewayArr,true)."\r\n",FILE_APPEND);
    $topics = array();
    //批量的订阅主题
    foreach($gatewayArr as $gateway){ 
        if($gateway['type']=='eciot-3S')
        {
            $topics['gateway/up/property/'.$gateway['topic']] = array('qos' => 0, 'function' => 'procmsg');
        }
        if($gateway['type']=='eciot-2M')
        {
            $topics['UPDATA/'.$gateway['company_code'].'_'.$gateway['project_code'].'/'.$gateway['sn']] = array('qos' => 0, 'function' => 'procmsg');
        }
    }
    
    //连接MQTT服务
    $mqttConfig = include_once("/eciot/htdocs/configs/mosquitto.php");
    $mqtt = new Bluerhinos\phpMQTT($mqttConfig['default']['server'], $mqttConfig['default']['port'], 'PROMSG_'.create_randomstr(10));
    $mqtt->debug = $mqttConfig['default']['debug'];

    if($mqtt->connect(true, NULL, $mqttConfig['default']['username'], $mqttConfig['default']['password']))
    { 
        $mqtt->subscribe($topics, 0); 
        while($mqtt->proc()){}
        @file_put_contents('/eciot/htdocs/service/log/promsg_'.date("Ymd").'.log',date('YmdHis')."===========================\nmqtt runing done......\r\n",FILE_APPEND);
        $mqtt->close();
    }
    else 
    {
        echo 'mqtt connect fail......';
        @file_put_contents('/eciot/htdocs/service/log/promsg_'.date("Ymd").'.log',date('YmdHis')."===========================\nmqtt connect fail......\r\n",FILE_APPEND);
    }

}
else 
{
    echo 'gateway is empty......';
    exit;
}
unlink($file_lock);
mysqli_close($conn);
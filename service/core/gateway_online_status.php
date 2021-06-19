<?php
/*
网关、设备在MQTT上的状态 
by MuskChan at 0414/2020
重要：chmod 777 /htdocs/mqtt/mosquitto.log
重要：/htdocs/mqtt/mosquitto.conf 增加一行 log_dest file /htdocs/mqtt/mosquitto.log
重要：/usr/local/sbin/mosquitto -c /htdocs/mqtt/mosquitto.conf -d 须以此方式启动
1619341658: Socket error on client MTK768802004C4F50, disconnecting.
1619341667: New client connected from 180.110.209.202 as MTK768802004C4F50 (c1, k60, u'MTK768802004C4F50').
1619343923: Socket error on client MH803151, disconnecting.
1619343052: New client connected from 180.110.209.202 as MH803151 (c1, k120, u'MH803151').
*/
error_reporting(0); 
$logArr = null;
$logTmp = null;
$gatewayArr = null;
$logTmpCount = 0;
$logTxt = file_get_contents('/htdocs/mqtt/mosquitto.log');
$logTmp = explode("\n",$logTxt);
$logTmpCount = count($logTmp);
// var_dump($logTmp);
include_once('/eciot/htdocs/service/core/db.init.php');
if($logTmpCount>1)
{
    $sql = "SELECT * FROM `eciot_gateway` WHERE is_reg=2 and client_id<>''";//所有已在云平台注册的网关
    $gatewayArr = query($sql,$conn);
    
    file_put_contents('/htdocs/mqtt/mosquitto.log','');//重置为空
    foreach($logTmp as $row_id=>$row_val){
        
        if(count($gatewayArr)>0)
        {
            foreach($gatewayArr as $gateway){
                if(strpos($row_val,'Socket error on client '.$gateway['client_id'].', disconnecting.'))//解析离线报文
                {
                    $sql = "update `eciot_gateway` set is_online=0,heartbeat_time='".date('Y-m-d H:i:s')."' WHERE client_id='".$gateway['client_id']."'";
                    querysql($sql,$conn);
                    // print_r(array('ROW_VAL'=>$row_val,'SQL'=>$sql));
                    file_put_contents('/htdocs/mqtt/mosquitto.log',$logTmp[$row_id]."\n",FILE_APPEND);//重写日志
                }
                elseif(strpos($row_val,'as '.$gateway['client_id'].' ('))//解析上线报文
                {
                    $sql = "update `eciot_gateway` set is_online=1,heartbeat_time='".date('Y-m-d H:i:s')."' WHERE client_id='".$gateway['client_id']."'";
                    querysql($sql,$conn);
                    // print_r(array('ROW_VAL'=>$row_val,'SQL'=>$sql));
                    file_put_contents('/htdocs/mqtt/mosquitto.log',$logTmp[$row_id]."\n",FILE_APPEND);//重写日志
                }
            }
        }
    }
    //另存给基础平台的服务日志
    file_put_contents('/eciot/htdocs/service/log/online_'.date("Ymd").'.log',file_get_contents('/htdocs/mqtt/mosquitto.log'));
    returnJson('200', '操作成功');
}

returnJson('500', '操作失败');

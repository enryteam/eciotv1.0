<?php
/*
  crontab 每15秒执行一次
  gateway_terminal_healthy
  网关及设备健康的状态：告警/维修/工单 
  配合restful接口使用
  by MuskChan at 0421/2020
*/
error_reporting(0); 
include_once('/eciot/htdocs/service/core/db.init.php');
$sql = "SELECT * FROM `eciot_gateway` WHERE is_reg=2 and client_id<>''";
$gatewayArr = query($sql,$conn);
if($gatewayArr)
{
    foreach($gatewayArr as $gateway){   
        if($gateway['is_online']==1){
            $sql = "select * from `eciot_gateway_terminal` where is_disable=1 and fault>1 and gateway_id='".$gateway['id']."'";
            $terminalArr = query($sql,$conn);
            if($terminalArr){
                foreach($terminalArr as $terminal){
                    //TODO调用协议创建对应设备订单 type=1是设备故障
                    $url="http://".$_SERVER['SERVER_NAME']."/rest/index.php?c=workorder_encode&a=order&terminal_id=".$terminal['id']."&type=1";
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
        else 
        {
            //TODO调用协议创建对应网关订单  type=2是网关 故障
            $url="http://".$_SERVER['SERVER_NAME']."/rest/index.php?c=workorder_encode&a=order&gateway_id=".$gateway['id']."&type=2";
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





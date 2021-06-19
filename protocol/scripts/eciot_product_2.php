<?php 

// //LED灯的功能

// //默认参数$conn,$gateway,$terminal,$arr

 function eciot_product_2($conn,$gateway,$terminal,$arr){

	//  //开关类终端设备参考START

	//  if($arr['params']['lightvalue']==1){

	//   $sql = "SELECT * FROM `eciot_gateway_state` where product_id = '".$terminal['product_id']."' and name = '开'";

	//  }else{

	//   $sql = "SELECT * FROM `eciot_gateway_state` where product_id = '".$terminal['product_id']."' and name = '关'";

	//  }

	//     $state = queryone($sql, $conn);

	//  $sql = "UPDATE `eciot_gateway_terminal` SET `state`='".$state['id']."' WHERE sn = '".$terminal['sn']."'";

	//  $res = querysql($sql,$conn);

	//  //开关类终端设备参考OVER

}

// //LED灯的功能

// //默认参数$conn,$gateway,$terminal,$arr

// function eciot_product_2($conn,$gateway,$terminal,$arr){

//  //传感器类终端设备参考START

//  $sql = "INSERT INTO `eciot_product_2`(`terminal_id`, `sn`, `pm1`, `pm2`, `ctime`) VALUES ('".$terminal['id']."','".$terminal['sn']."','".$arr['params']['pm25']."','".$arr['params']['pm100']."','".$arr['timestamp']."')";

//  $res = querysql($sql,$conn);

//  //传感器类终端设备参考OVER

// }

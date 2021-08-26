<?php
defined('IN_PHPFRAME') or exit('No permission resources.');
pc_base::load_app_class('BmsAction');

//产品管理
class product extends BmsAction {
  private $model = null;

  public function __construct() {
    $model = D('Bms');
    $this->model = $model;
    parent::__construct();
  }

  //产品管理
  public function index() {
    parent::rule(__METHOD__);
    $model = $this->model;
    $page_size = $_SESSION['pageSize'];
    $page = max(getgpc('page'), 1);
    $sql = " SELECT * FROM `eciot_product` where 1=1 ";
    if($type_id){
      $search['type'] = $type_id;
      $sql.= " and type_id = $type_id";
    }
    if($gateway_id){
      $search['gateway_id'] = $gateway_id;
      $sql .= " and gateway_id = $gateway_id";
    }
    $count = $model->ecount($sql);
    $sql .= " order by id desc";
    $arr = $model->query($sql . " limit " . ($page - 1) * $page_size . "," . $page_size);
    foreach ($arr as $key => $vo) {
      $re = $model->queryone("SELECT * FROM `eciot_product_cate` where id = ".$vo['cate_id']);
      $arr[$key]['cate_title'] = $re['cate_title'];
    }
    $this->assign('lists', $arr);
    $this->assign('page',$page);
    $pages = pages_layer($count, $page, $page_size, '', $search);
    $this->assign('pages', $pages);
    $this->assign('search', $search);
    $this->display();
  }

  //新增/修改产品
    public function edit() {
        parent::rule(__METHOD__);
        $model = $this->model;
        $id=getgpc("id");
        $page=getgpc('page');
        $this->assign('page',$page);
        if(isPost()){
            $id=getgpc('id');
            $name=getgpc("name");
            $cate_id=getgpc("cate_id");
            $iottype=getgpc('iottype');
            $drive_id=getgpc('drive_id');
            $protocol_id=getgpc('protocol_id');
            $is_connect=getgpc('is_connect');
            $remark=getgpc('remark');
            $image=getgpc('image');
            if(!$id){
                $drive_re=$model->queryone("select * from eciot_product where thingtype='".$drive_id."' and name='".$name."' ");
                if($drive_re){
                    returnJson('500','此驱动类型已经存在');
                }
               $sql="INSERT INTO `eciot_product`( `cate_id`,  `name`,  `protocol_id`,`iottype`,`thingtype`,`image`, `is_connect`, `remark`) VALUES ('".$cate_id."','".$name."','".$protocol_id."','".$iottype."','".$drive_id."','".$image."','".$is_connect."','".$remark."')";
                $res=$model->querysql($sql);
                if($res){
                    $product_id=  mysql_insert_id();
                    $sql = "CREATE TABLE `eciot_product_".$product_id. "` (
                            `id` int(11) NOT NULL AUTO_INCREMENT,
                            `terminal_id` int(11) not NULL COMMENT '设备ID',
                            `sn` varchar(50) DEFAULT NULL COMMENT '设备SN',
                            `ctime`  varchar(22) DEFAULT NULL COMMENT '时间',
                            PRIMARY KEY (`id`)
                        )ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='eciot_product_".$product_id.$day."表'";
                        $model->querysql($sql);
                        $user_path="../protocol/scripts/eciot_product_".$product_id.".php";  
                        //判断该用户文件夹是否已经有这个文件夹  
						$longtext='<?php '."\n".'
// //##51daniu.cn##的功能'."\n".'
// //默认参数$conn,$gateway,$terminal,$arr'."\n".'
 function @@51daniu.cn@@($conn,$gateway,$terminal,$arr){'."\n".'
	//  //开关类终端设备参考START'."\n".'
	//  if($arr[\'params\'][\'lightvalue\']==1){'."\n".'
	//   $sql = "SELECT * FROM `eciot_gateway_state` where product_id = \'".$terminal[\'product_id\']."\' and name = \'开\'";'."\n".'
	//  }else{'."\n".'
	//   $sql = "SELECT * FROM `eciot_gateway_state` where product_id = \'".$terminal[\'product_id\']."\' and name = \'关\'";'."\n".'
	//  }'."\n".'
	//     $state = queryone($sql, $conn);'."\n".'
	//  $sql = "UPDATE `eciot_gateway_terminal` SET `state`=\'".$state[\'id\']."\' WHERE sn = \'".$terminal[\'sn\']."\'";'."\n".'
	//  $res = querysql($sql,$conn);'."\n".'
	//  //开关类终端设备参考OVER'."\n".'
}'."\n".'
// //##51daniu.cn##的功能'."\n".'
// //默认参数$conn,$gateway,$terminal,$arr'."\n".'
// function @@51daniu.cn@@($conn,$gateway,$terminal,$arr){'."\n".'
//  //传感器类终端设备参考START'."\n".'
//  $sql = "INSERT INTO `@@51daniu.cn@@`(`terminal_id`, `sn`, `pm1`, `pm2`, `ctime`) VALUES (\'".$terminal[\'id\']."\',\'".$terminal[\'sn\']."\',\'".$arr[\'params\'][\'pm25\']."\',\'".$arr[\'params\'][\'pm100\']."\',\'".$arr[\'timestamp\']."\')";'."\n".'
//  $res = querysql($sql,$conn);'."\n".'
//  //传感器类终端设备参考OVER'."\n".'
// }'."\n";
							
						$longtext=str_replace('##51daniu.cn##',$name,$longtext);
						$longtext=str_replace('@@51daniu.cn@@','eciot_product_'.$product_id,$longtext);
                        file_put_contents($user_path,$longtext);
                    returnJson('200','操作成功');
                }else{
                    returnJson('500','操作失败');
                }
            }else{
                $drive_re=$model->queryone("select * from eciot_product where thingtype='".$drive_id."' and name='".$name."' and id <>'".$id."'");
                if($drive_re){
                    returnJson('500','此驱动类型已经存在');
                }
                $sql="update `eciot_product` set `cate_id`='".$cate_id."', `name`='".$name."',`iottype`='".$iottype."',`thingtype`='".$drive_id."', `protocol_id`='".$protocol_id."',`image`='".$image."', `is_connect`='".$is_connect."', `remark`='".$remark."' where id='".$id."'";
                $res=$model->querysql($sql);
                if($res){
                    returnJson('200','操作成功');
                }else{
                    returnJson('500','操作失败');
                }
            }
            
        }
        $re=$model->queryone("select * from `eciot_product` where id='".$id."'");
        $this->assign("details",$re);
        //产品分类
        $cate=$model->query("select * from `eciot_product_cate` ");
        $this->assign("cate",$cate);
        //协议列表、
        $protocol=$model->query("select * from `eciot_protocol` where protocol_publish=1 ");
        $this->assign("protocol",$protocol);
        //驱动包
        $drive=$model->query("select * from `eciot_drive` ");
        $this->assign('drive',$drive);
        $this->display();

    }

	///  重载物模型
	public function reload(){
		$file_txt=file_get_contents('../service/core/eciot3s_mqtt_subscribe_copy.php');
        $filetext=file_put_contents('../service/core/eciot3s_mqtt_subscribe.php',$file_txt);
        if($filetext){
            returnJson('200','操作成功');
        }else{
            returnJson('500','重载失败,无写入权限');
        }
		
	}
    
    
    //删除remove
    public function remove(){
        parent::rule(__METHOD__);
        $model=$this->model;
        $id=getgpc('id');
        $page=getgpc('page');
        $re=$model->queryone("select * from `eciot_product` where id='".$id."' ");
        if($re){
            $r=$model->queryone("select * from `eciot_product_nature` where product_id='".$id."' ");
            if($r){
                bmsAlert('此产品已有属性，请勿删除',pfUrl('','product','index'));
            }
            $r=$model->queryone("select * from `eciot_product_state` where product_id='".$id."' ");
            if($r){
                bmsAlert('此产品已有事件，请勿删除',pfUrl('','product','index'));
            }
            
            $r=$model->querysql("delete from `eciot_product` where id='".$id."'");
            if($r){
                header("Location:".pfUrl('','product','index',array('page'=>$page)));
            }else{
                 bmsAlert('删除失败',pfUrl('','product','index',array('page'=>$page)));
            }
        }else{
            bmsAlert('参数错误',pfUrl('','product','index',array('page'=>$page)));
        }
    }
    
    //属性列表
    public function nature(){
        parent::rule(__METHOD__);
        $model=$this->model;
        $page_size = $_SESSION['pageSize'];
        $page1=getgpc('page');
        $this->assign('page',$page1);
        $page = max(getgpc('page'), 1);
        $product_id=getgpc("product_id");
        $r=$model->queryone("select * from `eciot_product` where id='".$product_id."'");
        $this->assign('r',$r);
        $sql = " SELECT * FROM `eciot_product_nature`  where product_id='".$product_id."' ";
        $count = $model->ecount($sql);
        $sql .= " order by id desc";
        $arr = $model->query($sql . " limit " . ($page - 1) * $page_size . "," . $page_size);
        $this->assign('lists', $arr);
        $this->assign('count',$count);
        $pages = pages_layer($count, $page, $page_size, '', $search);
        $this->assign('pages', $pages);
        $this->assign('search', $search);
        $this->display();
    }
    
   //属性建立
    public function nature_edit(){
        parent::rule(__METHOD__);
        $model=$this->model;
        $page1=getgpc('page');
        $this->assign('page',$page1);
        if(isPost()){
            $id=getgpc('id');
            $product_id=getgpc("product_id");
            $nature=getgpc('nature');
            $nature_name=getgpc('nature_name');
            $type=getgpc('type');
            $nature_float=getgpc('nature_float');
            $remark=getgpc("remark");
            $ctime=date("Y-m-d H:i:s");
            $default_value=getgpc("default_value");
            if($type=='int'){
                if($default_value){
                    $type1="INT(10) NULL DEFAULT '".$default_value."' COMMENT";
                }else{
                    $type1="INT(10) NULL COMMENT";
                }
            }else if($type=='varchar'){
                if($default_value){
                    $type1="varchar(255) DEFAULT '".$default_value."' COMMENT";
                }else{
                    $type1="VARCHAR(255) NULL COMMENT";
                }
            }elseif($type=='float'){
                if($nature_float){
                    $type1="FLOAT(15) NULL DEFAULT '".$nature_float."' COMMENT";
                }else{
                    $type1="FLOAT(22) NULL COMMENT";
                }
            }
            if(!$id){
                //线判断当前产品的属性是否有相同的 相同的不给注册
                $rr=$model->queryone("select * from `eciot_product_nature` where product_id='".$product_id."' and nature='".$nature."'");
                if($rr){
                    returnJson("500",'此产品属性已经纯在');
                }
                $sql="INSERT INTO `eciot_product_nature`(`product_id`, `nature`, `nature_name`,`default_value`, `type`,`nature_float`, `remark`, `ctime`) VALUES ('".$product_id."','".$nature."','".$nature_name."','".$default_value."','".$type."','".$nature_float."','".$remark."','".$ctime."')";
                 $res=$model->querysql($sql);
                if($res){
                    $day=date('Ymd');
                    $rer=$model->query("show columns from `eciot_product_".$product_id. "`");
                    $count=count($rer);
                    $end_name=$rer[$count-1]['Field'];
                    if($rer){
                        foreach($rer as $ke=>$vo){
                            if($vo['Field']==$nature){
                                 returnJson("500",'此字段存在');
                            }else{
                                $sql="ALTER TABLE `eciot_product_".$product_id. "` ADD `".$nature."` ".$type1." '".$nature_name."' AFTER `".$end_name."`;";
                                $model->querysql($sql);
                            }
                        }
                    }else{
                        $sql = "CREATE TABLE `eciot_product_".$product_id. "` (
                            `id` int(11) NOT NULL AUTO_INCREMENT ,
                            `terminal_id` int(11) not NULL COMMENT '设备ID',
                            `sn` varchar(50) DEFAULT NULL COMMENT '设备SN',
                            `".$nature."` ".$type1." '".$nature_name."',
                            `ctime`  varchar(22) DEFAULT NULL COMMENT '时间',
                            PRIMARY KEY (`id`)
                        )ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='".$nature_name.$day."表'";
                        $model->querysql($sql);
                        $user_path="../protocol/scripts/eciot_product_".$product_id.".php";  
                        //判断该用户文件夹是否已经有这个文件夹  
                        file_put_contents($user_path,'<?php  //开始编写脚本');
                    }
                    returnJson("200",'操作成功');
                }else{
                    returnJson("500",'操作失败');
                }
            }else{
                 //线判断当前产品的属性是否有相同的 相同的不给注册
                $rr=$model->queryone("select * from `eciot_product_nature` where product_id='".$product_id."' and nature='".$nature."' and id<>'".$id."' ");
                if($rr){
                    returnJson("500",'此产品属性已经纯在');
                }
                //如果是修改表字段首先 先判断 这个表是否有数据  没有  可已修还  有不可修改
                $re1=$model->queryone("select * from `eciot_product_".$product_id. "` ");
                if($re1){
                    returnJson("500",'此表已经存在数据不可修改');
                }
                //查询需要修改的表字段的值
                $re2=$model->queryone("select * from `eciot_product_nature` where id='".$id."'");
                $rer=$model->query("show columns from `eciot_product_".$product_id. "`");
                $end_name=$rer[$count-1]['Field'];
                if($rer){
                    foreach($rer as $ke=>$vo){
                        if($vo['Field']==$re2['nature']){
                            // $type1='varchar(255) DEFAULT NULL COMMENT';
                            $sql = "ALTER TABLE `eciot_product_".$product_id. "` CHANGE `".$re2['nature']."` `".$nature."` ".$type1." '".$nature_name."';";
                            $rrr=$model->querysql($sql);
                            if(!$rrr){
                                returnJson("500",'此字段存在不可修改');
                            }
                        }
                    }
                }                  
                $sql="update `eciot_product_nature` set `product_id`='".$product_id."',`nature`='".$nature."',`nature_name`='".$nature_name."',`default_value`='".$default_value."',`type`='".$type."',nature_float='".$nature_float."',`remark`='".$remark."' where id='".$id."'";
                $res=$model->querysql($sql);
                if($res){
                    returnJson("200",'操作成功');
                }else{
                    returnJson("500",'操作失败');
                }
            }
           
        }
        $id=getgpc("id");
        $product_id=getgpc("product_id");
        $this->assign("product_id",$product_id);
        $re=$model->queryone("select * from `eciot_product_nature` where id='".$id."'");
        $this->assign("details",$re);
        $this->display();
        
    }
    
    //删除文件
    public function nature_remove(){
        parent::rule(__METHOD__);
        $model=$this->model;
        $id=getgpc("id");
        $page1=getgpc('page');
        $this->assign('page',$page1);
        $product_id=getgpc('product_id');
        $re=$model->queryone("select * from `eciot_product_nature` where id='".$id."'");
        $r=$model->querysql("delete from `eciot_product_nature` where id='".$id."' ");
        if($re && $r){
            header("Location:".pfUrl('','product','nature',array('product_id'=>$product_id)));
        }else{
            bmsAlert('删除失败',pfUrl('','product','nature_remove',array('product_id'=>$product_id)));
        }
    }
    
    //脚本编辑页面
    public function product_edit(){
        parent::rule(__METHOD__);
        $model=$this->model;
        $product_id=getgpc("product_id");
        $product=$model->queryone("select * from `eciot_product` where id='".$product_id."' ");
        $this->assign('r',$product);
        $this->assign('product_id',$product_id);
        $cfile="../protocol/scripts/eciot_product_".$product_id.".php";
        $cfilehandle=fopen($cfile,"r");
        $editfile=fread($cfilehandle,filesize($cfile));
         $this->assign('editfile',$editfile);
        fclose($cfilehandle);
        if(isPost()){
            $copy = $_POST['copy'];
            $product_id=$_POST['product_id'];
            $file ="../protocol/scripts/eciot_product_".$product_id.".php"; 
            //php脚本语法检查===start====
            $temp = str_replace('.php','_tmp.php',$file);
            file_put_contents($temp,'');//临时文件
            $cfilehandle=fopen($temp,"wb");
            flock($cfilehandle,2);
            fputs($cfilehandle,stripslashes(str_replace("/x0d/x0a","/x0a",$copy)));
            fclose($cfilehandle); 
            exec('php -l '.$temp,$exec);
            unlink($temp);
            if($exec[1])
            {
                echo '<div style="background:#1E9FFF;margin:10px;padding:10px;color:white;">';
                echo '撸码辛苦了~发现这个脚本还有语法错误呐，请再处理下吧 ^_^<br><br>';
                echo str_replace('_tmp.php','.php',$exec[1]);
                echo '</div>';
                $this->assign('editfile',stripslashes(str_replace("/x0d/x0a","/x0a",$copy)));

            }
            else 
            {
                $cfilehandle=fopen($file,"wb");
                flock($cfilehandle,2);
                fputs($cfilehandle,stripslashes(str_replace("/x0d/x0a","/x0a",$copy)));
                fclose($cfilehandle);            
                header("Location:".pfUrl('','product','index',array('product_id'=>$product_id)));
                exit;
                
            }
            //php脚本语法检查===over=====
            
        }
        $this->display();
    }
    
    //功能内容写入文件
    public function ability(){
        parent::rule(__METHOD__);
        $model=$this->model;
        $product_id=getgpc('product_id');
        $code = $_FILES['file']; //获取小程序传来的图片
        if (is_uploaded_file($_FILES['file']['tmp_name'])) {
          //把文件转存到你希望的目录（不要使用copy函数）  
          $uploaded_file = $_FILES['file']['tmp_name'];
          //我们给每个用户动态的创建一个文件夹   
          $user_path = "./".date('Ymdhis').rand(10,99);
          $file_true_name = $_FILES['file']['name'];
          $move_to_file = $user_path .".txt";  
          if (move_uploaded_file($uploaded_file, iconv("utf-8", "gb2312", $move_to_file))) {
                        $file_arr=file_get_contents($move_to_file);
                    returnJson('200', '上传成功',array('file_txt'=>$move_to_file,'content'=>json_encode($file_arr)));
          }else{
            returnJson('500', '上传失败', $url);
          }
         }else{
             returnJson('500', '上传失败', $url);
          }
    }
    public function ability_port(){
		$model=$this->model;
                $product_id=getgpc('product_id');
                $move_to_file=getgpc('file_addr');
		$file_arr=file_get_contents($move_to_file);
		 $file ="../protocol/scripts/eciot_product_".$product_id.".php"; 
                 //写入文件
                 file_put_contents($file,$file_arr);
                 unlink($move_to_file);
                returnJson("200",'写入文件成功');
	}
        
        
         //产品事件
    public function gateway_state(){
        parent::rule(__METHOD__);
        $model=$this->model;
         $page_size = $_SESSION['pageSize'];
        $page = max(getgpc('page'), 1);
        $product_id=getgpc("product_id");
        $r=$model->queryone("select * from `eciot_product` where id='".$product_id."'");
        $this->assign('r',$r);
        $sql = " SELECT * FROM `eciot_product_state`  where product_id='".$product_id."' ";
        $count = $model->ecount($sql);
        $sql .= " order by id desc";
        $arr = $model->query($sql . " limit " . ($page - 1) * $page_size . "," . $page_size);
        foreach ($arr as $key => $vo) {
            $re = $model->queryone("SELECT * FROM `eciot_product` where id = ".$vo['product_id']);
            $arr[$key]['title'] = $re['id']."  —  ".$re['name'];
        }
        $this->assign('lists', $arr);
        $this->assign('count',$count);
        $pages = pages_layer($count, $page, $page_size, '', $search);
        $this->assign('pages', $pages);
        $this->assign('search', $search);
        $this->display();
    }
    
    //产品状态添加修改
    public function gateway_state_edit(){
        parent::rule(__METHOD__);
        $model=$this->model;
        if(isPost()){
            $id=getgpc('id');
            $product_id=getgpc('product_id');
            $name=getgpc('name');
            $keys=getgpc('keys');
            $value=getgpc('value');
            $content='{"'.$keys.'":"'.$value.'"}';
            if(!$id){
                $sql="INSERT INTO `eciot_product_state`(`product_id`, `name`, `content`) VALUES ('".$product_id."','".$name."','".$content."')";
            }else{
                $sql="update  `eciot_product_state` set  `product_id`='".$product_id."', `name`='".$name."', `content`='".$content."' where id='".$id."' ";
            }
            $res=$model->querysql($sql);
            if($res){
                returnJson('200','操作成功');
            }else{
                returnJson('500','操作失败');
            }
        }
        $id=getgpc('id');
        $product_id=getgpc('product_id');
        $this->assign('product_id',$product_id);
        $re=$model->queryone("select * from `eciot_product_state` where id='".$id."'");
        $arr=explode(':',$re['content']);
        $pattern = '#"(.*?)"#i'; 
        preg_match_all($pattern, $arr[0], $matches); 
        $re['keys']=$matches[1][0];
        preg_match_all($pattern, $arr[1], $matches1); 
        $re['value']=$matches1[1][0];
        $this->assign('details',$re);
        $this->display();
    }
    
    //产品 状态删除
    public function gateway_state_remove(){
        parent::rule(__METHOD__);
        $model=$this->model;
        $id=getgpc('id');
        $product_id=getgpc('product_id');
        $re=$model->queryone("select * from `eciot_product_state`  where id='".$id."'");
        if($re){
            $r=$model->querysql("delete from `eciot_product_state`  where id='".$id."'");
            if($r){
                header("Location:".pfUrl('','product','gateway_state',array('product_id'=>$product_id)));
            }else{
                 bmsAlert('删除失败',pfUrl('','product','gateway_state',array('product_id'=>$product_id)));
            }
        }else{
            bmsAlert('参数错误',pfUrl('','product','gateway_state',array('product_id'=>$product_id)));
        }
    }

    //// 产品图标列表
    public function lists(){
        $model=$this->model;
        $res=$model->query("select * from eciot_product_icon ");
        $this->assign('lists',$res);
        $this->display();
    }
    

}

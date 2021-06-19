<?php

defined('IN_PHPFRAME') or exit('No permission resources.');
pc_base::load_app_class('BmsAction');

class upfile extends BmsAction {

  public $path;

  public function __construct() {
  }

  public function index() {
    returnJson('200', 'Welcome to 51daniu.cn');
  }

  //上传图片--非 base64上传
     public function file_img(){
            $code = $_FILES['file'];//获取小程序传来的图片
            if(is_uploaded_file($_FILES['file']['tmp_name'])) {  
                //把文件转存到你希望的目录（不要使用copy函数）  
                $uploaded_file=$_FILES['file']['tmp_name'];  
                $username = "min_img";
                $type = explode("/",$code['type']);
                $user_path = iconv("UTF-8", "GBK",$_SERVER['DOCUMENT_ROOT']."/attms/upfile/".date('Y')."/".date('m')."/".date('d')."/");
                if (!file_exists($user_path)){
                    @mkdir ($user_path,0777,true);
                    //echo '创建文件夹bookcover成功';
                } 
                $file_true_name=$_FILES['file']['name'];
              //strrops($file_true,".")查找“.”在字符串中最后一次出现的位置  
                $IMG=time().rand(1,1000).substr($file_true_name,strrpos($file_true_name,"."));//文件名
                $move_to_file=$user_path.$IMG;  
                if(move_uploaded_file($uploaded_file,iconv("utf-8","gb2312",$move_to_file))) {  
                    $move_to_file=str_replace($_SERVER['DOCUMENT_ROOT'],"http://".$_SERVER['SERVER_NAME'],$move_to_file);
                    returnJson('200', '已完成', $move_to_file);
                } else {  
                   returnJson('500','上传失败');
                }  
            } else {  
                 returnJson('500','上传失败');
            }
    }
           

}

?>

<?php 
defined('IN_PHPFRAME') or exit('No permission resources.');
pc_base::load_app_class('BmsAction');

//控制台
class dashboard extends BmsAction {
  private $model = null;
  public function __construct() {
    parent::__construct();
    $model = D('Bms');
    $this->model = $model;
  }
  //默认
  public function index()
  {
    header("location:./index.php?c=dashboard&a=chart");
    exit;
  }
  //默认
  public function console()
  {
    header("location:./index.php?c=dashboard&a=chart");
    exit;
  }
 
  //设备看板
  public function device(){
    parent::rule(__METHOD__);
    $model=$this->model;
    //查询产品分类
    $res=$model->query("select * from eciot_product_cate");
    foreach($res as $ke=>$vo){
        $product=$model->query("select * from eciot_product where cate_id='".$vo['id']."'");
        foreach($product as $k=>$v){
          $product[$k]['prodcut_catename']=$vo['cate_title']."-".$v['name'];
          $terminal=$model->query("select * from eciot_gateway_terminal where product_id='".$v['id']."' order by id desc limit 50 ");
          foreach($terminal as $kk=>$vv){
            if($vv['state']>0){
              $state=$model->queryone("select a.id,a.name,a.content,b.image from eciot_product_state a,eciot_product b where a.product_id='".$vv['product_id']."' and a.product_id=b.id and a.id='".$vv['state']."' ");
              if($state){
                $terminal[$kk]['state']=$state;
              }
            }else{
              $state=$model->queryone("select image from eciot_product  where id='".$vv['product_id']."' ");
              if($state){
                $terminal[$kk]['state']=$state;
              }
            }
          }
          $product[$k]['terminal']=$terminal;
          $state=$model->query("select * from `eciot_product_state` where product_id='".$v['id']."'");
          $product[$k]['product_state']=$state;
        }
        $res[$ke]['product']=$product;
    }
    $this->assign('res',$res);
    $this->display();
  }

  //设备看板 群控管理
  public function device_open(){
    parent::rule(__METHOD__);
    $model=$this->model;
    $product_id=getgpc("product_id");
    $building_id=getgpc('building_id');
    $online=getgpc("online");
    if($product_id){
        $state=$model->query("select * from `eciot_product_state` where product_id='".$product_id."'");
        $arr=array();
        foreach($state as $ke=>$vo){
            if($online==1 ){
              $arr[]=$vo['product_id'];
            }else if($online==2 ){
              $arr[]=$vo['product_id'];
            }
        }
        if(!$arr){
          returnJson("500",'此产品无设备控制');
        }
        $pro_ids=implode(',',$arr);
        $terminal=$model->query("select * from `eciot_gateway_terminal` where product_id in($pro_ids) and online=1 and is_disable=1 and fault=1 ");
        foreach($terminal as $k=>$v){
              $gateway=$model->queryone("select * from `eciot_gateway` where is_online=1 and id='".$v['gateway_id']."'");
              $product=$model->queryone("select * from `eciot_product` where id='".$v['product_id']."' ");
              if($online==1){
                $state=$model->queryone("select * from `eciot_product_state` where product_id='".$v['product_id']."' and name='开' ");
              }else{
                $state=$model->queryone("select * from `eciot_product_state` where product_id='".$v['product_id']."' and name='关' ");
              }
              $controller=str_replace('-','',strtolower($gateway['type']));
              $url = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['SERVER_NAME']."/protocol/index.php?c=".$controller."&a=building_gateway_terminal&product_id=".$v['product_id']."&state_id=".$state['id']."&name=".$state['name']."&building_id=".$v['building_id'];
              $ch = curl_init();
              curl_setopt($ch, CURLOPT_URL, $url);
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
              curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
              curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
              curl_setopt($ch, CURLOPT_POST, 1);
              curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
              $json_token = curl_exec($ch);
              curl_close($ch);
              returnJson("200",'设置成功');
            
        }
    }else if($building_id){
        $res=$model->queryone("select * from `eciot_building` where id='".$building_id."' ");
        $arr=$model->query("select * from `eciot_building`  ");
        $arr_all=$this->children_all($arr,$res['id']);
        $arr_build=array();
        foreach($arr_all as $kk=>$vv){
          $arr_build[]=$vv['id'];
        }
        $build_ids=implode(',',$arr_build);
        $terminal=$model->query("select * from `eciot_gateway_terminal` where building_id in($build_ids) and online=1 and is_disable=1 and fault=1 ");
        foreach($terminal as $k=>$v){
              $gateway=$model->queryone("select * from `eciot_gateway` where is_online=1 and id='".$v['gateway_id']."'");
              $product=$model->queryone("select * from `eciot_product` where id='".$v['product_id']."' ");
              if($online==1){
                $state=$model->queryone("select * from `eciot_product_state` where product_id='".$v['product_id']."' and name='开' ");
              }else{
                $state=$model->queryone("select * from `eciot_product_state` where product_id='".$v['product_id']."' and name='关' ");
              }
              $controller=str_replace('-','',strtolower($gateway['type']));
              $url = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['SERVER_NAME']."/protocol/index.php?c=".$controller."&a=building_gateway_terminal&product_id=".$v['product_id']."&state_id=".$state['id']."&name=".$state['name']."&building_id=".$v['building_id'];
              $ch = curl_init();
              curl_setopt($ch, CURLOPT_URL, $url);
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
              curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
              curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
              curl_setopt($ch, CURLOPT_POST, 1);
              curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
              $json_token = curl_exec($ch);
              curl_close($ch);
        } 
        returnJson("200",'设置成功');
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

  //区域看板 ****
  public function building(){
    parent::rule(__METHOD__);
    $model=$this->model;
    //按区域查询 其设备展示
    $building_id=getgpc("building_id");
    $sql="select * from eciot_building where 1=1 ";
    if($building_id){
      $sql .=" and id='".$building_id."'";
    }else{
      $build=$model->queryone("select id from `eciot_building` where fid=0 order by id asc ");
      $building_id=$build['id'];
      $sql .=" and fid=0 ";
    }
    $sql .=" order by id asc ";
    $res=$model->query($sql);
    $arr=$model->query("select * from eciot_building where fid<>0 ");
    $rrr=$model->queryone("select * from eciot_building where fid='".$res[0]['id']."' ");
    if($rrr){
      $res_all=$this->chuildenall_lists($arr,$res[0]['id']);
      //默认第一个主区域
      $this->assign('res_all',$res_all);
      $lists_all=array();
      foreach($res_all as $ke=>$vo){
        if($vo['text']){
          foreach($vo['text'] as $k=>$v){
              $lists_all[]=$v;
          }
        }else{
          $lists_all[]=$vo;
        }
      }
    }else{
      $lists_all=$res;
    }
    foreach($lists_all as $key=>$val){
        $terminal=$model->query("select * from eciot_gateway_terminal where building_id='".$val['id']."' order by id desc limit 50");
        foreach($terminal as $k=>$v){
          if($vv['state']>0){
            $state=$model->queryone("select a.id,a.name,a.content,b.image from eciot_product_state a,eciot_product b where a.product_id='".$vv['product_id']."' and a.product_id=b.id and a.id='".$vv['state']."' ");
            if($state){
              $terminal[$kk]['state']=$state;
            }
          }else{
            $state=$model->queryone("select image from eciot_product  where id='".$vv['product_id']."' ");
            if($state){
              $terminal[$kk]['state']=$state;
            }
          }  
        }
        $lists_all[$key]['terminal']=$terminal;
        if(!$val['build_name']){
          $r=$model->queryone("select * from  eciot_building where id='".$val['fid']."'");
          $lists_all[$key]['build_name']=$r['name']."-".$val['name'];
        }
    }
    $this->assign("lists_all",$lists_all);
    $this->assign('building_id',$building_id);
    $this->display(); 
  }

  ////******* 无限分类 ******* */
  public function children_all($arr,$id=0){
    static $resall=array();
    foreach($arr as $ke=>$vo){
          if($vo['fid']==$id){
            $resall[]=$vo;
            $this->children_all($arr,$vo['id']);
          }
    }
    return $resall;
}
  //// ******  区域看板 无限分类 **************
    public function children_lists($arr,$id=0){
      $resall=array();
      foreach($arr as $ke=>$vo){
            if($vo['fid']==$id){
              $resall[]=$vo;
            }
      }
      return $resall;
  }
  public function chuildenall_lists($arr,$id=0){
    $model=$this->model;
      $arrall=$this->children_lists($arr,$id);
      if($arrall){
        foreach($arrall as $ke=>$vo){
          $lists=$this->chuildenall_lists($arr,$vo['id']);
          $r=$model->query("select * from  eciot_building where fid='".$vo['id']."'");
          // file_put_contents("ddddd.log",$r);
          if($r){
            foreach($r as $k=>$v){
              $r[$k]['build_name']=$vo['name']."-".$v['name']."";
            }
            $arrall[$ke]['text']=$r;
          }else{
            $r=$model->queryone("select * from  eciot_building where id='".$vo['fid']."'");
            $arrall[$ke]['build_name']=$r['name']."-".$vo['name'];
            $arrall[$ke]['text']=[];
          }
          
        }
      }
      return $arrall;
  }
//// ******  区域看板 无限分类 **************

  ////*********** 区域看板数据左侧目录栏 无限分类
  public function children($arr,$id=0){
        $resall=array();
       foreach($arr as $ke=>$vo){
            if($vo['fid']==$id){
              $resall[]=$vo;
            }
       }
       return $resall;
  }
    public function chuildenall($arr,$id=0){
        $arrall=$this->children($arr,$id);
        if($arrall){
          foreach($arrall as $ke=>$vo){
            $arrall[$ke]['text']=$vo['name'];
            $lists=$this->chuildenall($arr,$vo['id']);
            $arrall[$ke]['children']=$lists;
          }
        }
        return $arrall;
    }

  //区域看板目录树json
  public function building_all(){
    parent::rule(__METHOD__);
    $model=$this->model;
    $building=$model->query("select id,fid,name from `eciot_building` ");
    //目录树无限递归
     $arr_all=$this->chuildenall($building,0);
     returnJson('200','查询成功',$arr_all);
    
  }
  ////***********  数据左侧目录栏 无限分类  **************************** */
  //数据看板
  public function chart(){ 
    $model->$this->model;
    //设备故障
    
    $this->display();
  }
  
  
}


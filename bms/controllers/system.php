<?php

defined('IN_PHPFRAME') or exit('No permission resources.');
pc_base::load_app_class('BmsAction');

//系统
class system extends BmsAction {

  private $model = null;

  public function __construct() {
    $model = D('Bms');
    $this->model = $model;
    parent::__construct();
  }
  ////////////////////////      系统  start           ////////
  //操作日志
  public function log_index() {
    parent::rule(__METHOD__);
    $model = $this->model;
    $page_size = $_SESSION['pageSize'];
    $page = max(getgpc('page'), 1);
    $admin_name = trim(getgpc('admin_name'));
    $start_time = trim(getgpc('start_time'));
    $end_time = trim(getgpc('end_time'));
    $sql = "SELECT * FROM `eciot_admin_log`";
    $sql_res = ' WHERE 1=1';
    if ($admin_name) {
      $sql1 = "SELECT * FROM `eciot_admin` WHERE name like '%" . $admin_name . "%'";
      $search['admin_name'] = $admin_name;
      $sql_res .= " and admin_id in ($sql1)";
    }
    if ($start_time) {
      $search['start_time'] = $start_time;
      $sql_res .= " and ctime >= '" . $start_time . "'";
    }
    if ($end_time) {
      $search['end_time'] = $end_time;
      $end_time = $end_time . ' 23:59:59';
      $sql_res .= " and ctime <= '" . $end_time . "'";
    }
    $sql .= " order by ctime desc";
    $count = $model->ecount(" `eciot_admin_log` ".$sql_res);
    $arr = $model->query($sql.$sql_res . " limit " . ($page - 1) * $page_size . "," . $page_size);
    $this->assign('lists', $arr);
    $pages = pages_layer($count, $page, $page_size, '', $search);
    $this->assign('pages', $pages);
    $this->assign('search', $search);
    $this->display();
  }


  // **********  部门管理 start  ****************************
  // 无限递归
    public function getChildren($arr,$id=0){
      static $array=array();
      foreach($arr as $ke=>$vo){
          if($vo['fid']==$id){
              $array[]=$vo;
              $this->getChildren($arr,$vo['id']);
          }
      }
      return $array;
  }
  //机构管理
  public function department_index(){
        parent::rule(__METHOD__);
        $model=$this->model;
        $page_size = $_SESSION["pageSize"];
        $page = max(getgpc('page'), 1);
        $sql="select * from `eciot_department` ";
        $arr = $model->query($sql);
        //p($arr);
        foreach ($arr as $ke => $vo) {
          $r = $model->queryone("select * from `eciot_department` where id='" . $vo['fid'] . "' ");
          $arr[$ke]['fid_name'] = $r['title'];
        }
        $arr_all=$this->getChildren($arr,0);

        $arr3=array();
        $count=count($arr_all);
        $start_num=$page_size*($page-1);
        for($i=$start_num;$i<$start_num+$page_size;$i++){
          if($arr_all[$i]){
            $arr3[]=$arr_all[$i];
          }
        }
        $this->assign('lists', $arr3);
        $pages = pages_layer($count, $page, $page_size, '', $search);
        $this->assign('pages', $pages);
        $this->assign('search', $search);
        $this->display();
   }

    //机构编辑
    public function department_edit(){
      parent::rule(__METHOD__);
      $model = $this->model;
      $id = getgpc('id');
      if (isPost()) {
          $id=getgpc('id');
        $title = getgpc('title');
        $fid=getgpc('fid');
        if($fid>0){
            $re=$model->queryone("select * from `eciot_department` where id='".$fid."'");
            if($re){
                $num=$re['num']+1;
            }else{
                $num=1;
            }
        }else{
            $num=1;
        }
        if ($id) {
          $sql = "UPDATE `eciot_department` SET `title`='".$title."',`fid`='" . $fid . "',`num`='".$num."' WHERE id = " . $id;
        } else {
          $sql = "INSERT INTO `eciot_department`(`title`, `fid`,`num`, `ctime`) VALUES ('".$title."','".$fid."','".$num."','" . $ctime . "')";
        }
        $res = $model->querySql($sql);
        if ($res) {
          returnJson('200', '编辑成功');
        } else {
          returnJson('500', '编辑失败');
        }
      }
      if ($id) {
        $sql = "SELECT * FROM `eciot_department` where id = " . $id;
        $detail = $model->queryone($sql);
        $this->assign('detail', $detail);
      }
     
      //查询部门无限分类
      $cate=$model->query("select * from `eciot_department` ");
      $cate_all=$this->getChildren($cate,0);
      $this->assign('cate',$cate_all);
      $this->display();
    }

    //机构删除
    public function department_remove(){
      parent::rule(__METHOD__);
        $model=$this->model;
        $id=getgpc('id');
        $re=$model->queryone("select * from `eciot_department` where id='".$id."'");
        if($re){
          $rr=$model->queryone("select * from `eciot_department` where fid='".$id."' ");
          if($rr){
            bmsAlert('此部门存在组，请勿删除',pfUrl('','system','department_index'));
          }
          $rr1=$model->queryone("select * from `eciot_department_user` where department_id='".$id."' ");
          if($rr1){
            bmsAlert('此部门存在管理员，请勿删除',pfUrl('','system','department_index'));
          }
          $r=$model->querysql("delete from `eciot_department` where id='".$id."'");
          if($r){
            header("Location:".pfUrl('','system','department_index'));
          }else{
            bmsAlert('删除失败',pfUrl('','system','department_index'));
          }
        }else{
          bmsAlert('参数错误',pfUrl('','system','department_index'));
        }
    }
   // **********  部门管理 end  ****************************

    //**********  成员管理  ********************************************* */
    public function user_index(){
      parent::rule(__METHOD__);
      $model=$this->model;
      $page_size = $_SESSION["pageSize"];
      $page = max(getgpc('page'), 1);
      $count = $model->count("`eciot_department_user`");
      $arr = $model->query("select * from `eciot_department_user` where is_del=0 order by id desc limit " . ($page - 1) * $page_size . "," . $page_size);
      //p($arr);
      foreach ($arr as $ke => $vo) {
        $r = $model->queryone("select * from `eciot_department` where id='" . $vo['department_id'] . "' ");
        $arr[$ke]['department'] = $r['title'];
      }
      $this->assign('lists', $arr);
      $pages = pages_layer($count, $page, $page_size, '', $search);
      $this->assign('pages', $pages);
      $this->assign('search', $search);
      $this->display();
    }
    //成员添加 编辑
    public function user_edit(){
      parent::rule(__METHOD__);
        $model=$this->model;
        if(isPost()){
          $id=getgpc("id");
          $department_id=getgpc('department_id');
          $user_name=getgpc("user_name");
          $phone=getgpc("phone");
          $addr=getgpc('addr');
          if(!$id){
            $sql="insert into `eciot_department_user`(`department_id`,`user_name`,`phone`,`addr`,`ctime`)VALUES('".$department_id."','".$user_name."','".$phone."','".$addr."','".date('Y-m-d H:i:s')."')";
          }else{
            $sql="update `eciot_department_user` set department_id='".$department_id."',user_name='".$user_name."',phone='".$phone."',addr='".$addr."' where id='".$id."'";
          }
          $re=$model->querysql($sql);
          if($re){
            returnJson('200','编辑成功');
          }else{
            returnJson('500','编辑失败');
          }
        }
        $id=getgpc('id');
        $res=$model->queryone("select * from `eciot_department_user` where id='".$id."'");
        $this->assign('detail',$res);
        //查询部门无限分类
        $cate=$model->query("select * from `eciot_department` ");
        $cate_all=$this->getChildren($cate,0);
        $this->assign('cate',$cate_all);
        $this->display();

    }

    //会员删除
    public function user_remove(){
      parent::rule(__METHOD__);
      $model=$this->model;
      $id=getgpc('id');
      $re=$model->queryone("select * from `eciot_department_user` where id='".$id."' ");
      if($re){
        $r=$model->querysql("update `eciot_department_user` set is_del=1 where id='".$id."' ");
        if($r){
          header("Location:".pfUrl('','system','user_index'));
        }else{
          bmsAlert('删除失败',pfUrl('','system','user_index'));
        }
      }else{
        bmsAlert('参数错误',pfUrl('','system','user_index'));
      }
    }
    //后勤服务
    public function user_service(){
      parent::rule(__METHOD__);
      $model=$this->model;
      $id=getgpc('id');
      $is_service=getgpc("is_service");
      $re=$model->queryone("select * from `eciot_department_user` where id='".$id."' ");
      if($re){
        $r=$model->querysql("update `eciot_department_user` set is_service='".$is_service."' where id='".$id."' ");
        if($r){
          header("Location:".pfUrl('','system','user_index'));
        }else{
          bmsAlert('操作失败',pfUrl('','system','user_index'));
        }
      }else{
        bmsAlert('参数错误',pfUrl('','system','user_index'));
      }
    }
  ////////////////////////      角色系统  end           ////////
  //管理员列表
  public function admin_index() {
    parent::rule(__METHOD__);
    $model = $this->model;
    $page_size = $_SESSION["pageSize"];
    $page = max(getgpc('page'), 1);
    $count = $model->count("`eciot_admin`");
    $arr = $model->query("select * from `eciot_admin` limit " . ($page - 1) * $page_size . "," . $page_size);
    //p($arr);
    foreach ($arr as $ke => $vo) {
      $r = $model->queryone("select * from `eciot_admin_group` where id='" . $vo['gid'] . "' ");
      $arr[$ke]['roles'] = $r['title'];
    }
    $this->assign('re', $arr);
    $pages = pages_layer($count, $page, $page_size, '', $search);
    $this->assign('pages', $pages);
    $this->assign('search', $search);
    $this->display();
  }

  public function admin_add() {
    parent::rule(__METHOD__);
    $model = $this->model;
    if (isPost()) {
      $user_name = getgpc('user_name');
      $real_name = getgpc('real_name');
      $admin_id = getgpc('admin_id');
      $department_id=getgpc("department_id");
      $password = trim(getgpc('password'));
      $is_del = getgpc('is_del');
      $gid = getgpc('gid'); 
      if (!$admin_id) {
        $password = md5(md5(trim(getgpc('password')) . '@eciot_open'));
        $re = $model->queryone("select * from `eciot_admin` where user_name='" . $user_name . "'");
        if ($re) {
          returnJson('500', '管理员账号已存在');
        }
        $res = $model->querysql("INSERT INTO `eciot_admin`(`user_name`, `real_name`, `password`,`gid`) VALUES ('$user_name','$real_name','$password','$gid')");
        if ($res) {
          returnJson('200', '添加成功');
        } else {
          returnJson('500', '添加失败');
        }
      } else {
        $re = $model->queryone("select * from `eciot_admin` where user_name='" . $user_name . "' and admin_id<> '$admin_id' ");
        if ($re) {
          returnJson('500', '管理员账号已存在');
        }
        $r = $model->queryone("select * from `eciot_admin` where admin_id= '$admin_id'");
        if ($password != $r['password']) {
          $password = md5(md5(trim(getgpc('password')) . '@eciot_open'));
        }
        $res = $model->querysql("update `eciot_admin` set `user_name`='$user_name', `real_name`='$real_name', `password`='$password',`gid`='$gid', `is_del`='$is_del' where  admin_id='$admin_id'");
        if ($res) {
          returnJson('200', '编辑成功');
        } else {
          returnJson('500', '编辑失败');
        }
      }
    }
    $admin_id = getgpc('admin_id');
    $admin = $model->queryone("select * from `eciot_admin` where admin_id='" . $admin_id . "'");
    $this->assign('detail', $admin);
    $res = $model->query("select * from `eciot_admin_group`");
    $this->assign('res', $res);
    $cate=$model->query("select * from `eciot_department` ");
    $cate_all=$this->getChildren($cate,0);
    $this->assign('cate',$cate_all);
    $this->display();
  }
  //删除 管理员
  public function admin_remove() {
    parent::rule(__METHOD__);
    $model = $this->model;
    $admin_id = getgpc('admin_id');
    $r = $model->queryone("select * from `eciot_admin` where admin_id='" . $admin_id . "'");
    if ($r) {
      $re = $model->querysql("delete from `eciot_admin` where admin_id='" . $admin_id . "'");
      if ($re) {
        header("Location:" . pfUrl('', 'system', 'admin_index'));
      } else {
        bmsAlert('操作失败', pfUrl('', 'system', 'admin_index'));
      }
    } else {
      bmsAlert('参数错误', pfUrl('', 'system', 'admin_index'));
    }
  }

  //
  //************   角色管理   *************************
  //角色列表
  public function roles_index() {
    parent::rule(__METHOD__);
    $model = $this->model;
    $page_size = $_SESSION["pageSize"];
    $page = max(getgpc('page'), 1);
    $count = $model->count("`eciot_admin_group`");
    $sql = " select * from `eciot_admin_group`  ";
    $arr = $model->query($sql . " limit " . ($page - 1) * $page_size . "," . $page_size);
    $this->assign('re', $arr);

    $pages = pages_layer($count, $page, $page_size, '', $search);
    $this->assign('pages', $pages);
    $this->assign('search', $search);

    $this->display();
  }

  //角色添加/编辑
  public function roles_add() {
    parent::rule(__METHOD__);
    $model = $this->model;
    if (ispost()) {
      $id = getgpc('id');
      $title = getgpc('title');
      $action = getgpc('action');
      $rules = implode(',', getgpc("rules"));
      $rules0 = implode(',', getgpc("rules0"));
      $rules1 = implode(',', getgpc("rules1"));
      $rules11 = implode(',', getgpc("rules11"));
      if(getgpc("rules0")){
        $rules=$rules.",".$rules0;
      }
      if(getgpc("rules1")){
        $rules=$rules.",".$rules1;
      }
      if(getgpc("rules11")){
        $rules=$rules.",".$rules11;
      }
      $status = getgpc('status');
      $remark = getgpc("remark");
      if (!$id) {
        $r = $model->queryone("select * from `eciot_admin_group` where title='" . $title . "'");
        if ($r) {
            bmsAlert("此角色组名称已存在", pfUrl("", "system", "roles_add", array('id' => $id)));
        }
        if(!$title){
            bmsAlert("请输入角色", pfUrl("", "system", "roles_add", array('id' => $id)));
        }
        if(!$rules){
            bmsAlert("请选择权限组", pfUrl("", "system", "roles_add", array('id' => $id)));
        }
        $res = $model->querysql("insert into `eciot_admin_group` (title,status,rules,remark)values('$title','$status','$rules','$remark')");
        if ($res) {
          header("location:" . pfUrl("", "system", "roles_index"));
        } else {
          bmsAlert("添加角色组失败", pfUrl("", "system", "roles_index"));
        }
      } else {
        $r = $model->queryone("select * from `eciot_admin_group` where title='" . $title . "' and id <> '$id' ");
        if ($r) {
          bmsAlert("此角色组名称已存在2", pfUrl("", "system", "roles_add", array('id' => $id)));
        }
        $res = $model->querysql("update `eciot_admin_group` set title='$title',status='$status',rules='$rules',remark='$remark' where id='$id'");
        if ($res) {
          parent::log(__METHOD__, '角色编辑:' . $title);
          header("location:" . pfUrl("", "system", "roles_index"));
        } else {
          bmsAlert("编辑角色组失败", pfUrl("", "system", "roles_add", array('id' => $id)));
        }
      }
    }
    $id = getgpc('id');
    $detail = $model->queryone("select * from `eciot_admin_group` where id = '$id'");
    $this->assign('detail', $detail);
    $res = $model->query("select * from `eciot_admin_side_action` where fid = 0 and status = 1");
    foreach ($res as $key => $vo) {
      $re = $model->query("select * from `eciot_admin_side_action`  where status = 1 and module<>'' and fid=" . $vo['id']);
      $res[$key]['zi'] = $re;
    }
    $this->assign('res', $res);
    $this->display();
  }

  public function roles_remove() {
    parent::rule(__METHOD__);
    $model = $this->model;
    $id = getgpc("id");
    $re = $model->queryone("select * from `eciot_admin_group` where id='$id'");
    if ($re) {
      $admin = $model->queryone("select * from `eciot_admin` where gid='$id' ");
      if ($admin) {
        bmsAlert("此角色组存在管理员,请先删除对应组的管理员", pfUrl("", "system", "roles_index"));
      }
      $re = $model->querysql("delete from `eciot_admin_group` where id='$id'");
      if ($re) {
        header("location:" . pfUrl("", "system", "roles_index"));
      } else {
        bmsAlert("删除角色组失败", pfUrl("", "system", "roles_index"));
      }
    } else {
      bmsAlert("参数错误", pfUrl("", "system", "roles_index"));
    }
  }

  ////权限服务 权限表写入
  public function admin_index_rule(){
      $model=$this->model;
      //查询数据
      $arr=$model->query("select * from `eciot_admin_side_action` ");
      $i=0;
      foreach($arr as $ke=>$vo){
        if($vo['fid']==0){
          $sql="update  `eciot_admin_side_action` set module='".$vo['controller']."::' where id='".$vo['id']."'";
          $model->querysql($sql);
        }else{
          $sql="update `eciot_admin_side_action` set module='".$vo['controller']."::".$vo['action']."' where id='".$vo['id']."'";
          $model->querysql($sql);
        }
          $i++;
      }
      returnJson('200','数据写入成功',$i."---数据----");

  }

  //// 权限服务 对应数据写入
  public function admin_index_action(){
      $model=$this->model;
      $res=$model->query("select * from `eciot_admin_rule` where fid=0");
      $arr=$model->query("select * from `eciot_admin_side_action` where fid=0 ");
      $i=0;
      foreach($res as $ke=>$vo){
        foreach($arr as $k=>$v){
          if($vo['action']==$v['controller']){
            $sql="INSERT INTO `eciot_admin_rule`(`action`, `module`, `title`, `fid`, `status`, `c_a_id`) VALUES ('".$vo['action']."','".$vo['controller']."::".$vo['action']."','".$vo['title']."','".$vo['id']."',1,'".$v['id']."')";
            $model->querysql($sql);
            $i++;
          }
        }
      }
      echo $i;
      returnJson('200','数据写入成功',$i."---数据----");
  }
  




}

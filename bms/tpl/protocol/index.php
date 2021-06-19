<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?=$_SESSION['logo']?></title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="./attms/ms/layuiadmin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="./attms/ms/layuiadmin/style/admin.css" media="all">
    <style>
      .laytable-cell-4-0-0{ width: 48px; }.laytable-cell-4-0-1{ width: 80px; }.laytable-cell-4-0-2{  }.laytable-cell-4-0-3{  }.laytable-cell-4-0-4{  }.laytable-cell-4-0-5{ width: 150px; }
      .layer_box{
        position:absolute;
        background: red;
        width:100px;
        height:100px;
        left:8%;
        z-index:9999999;
      }
    </style>
  </head>
  <body>

    <div class="layui-fluid">   
      <div class="layui-card">
        <div class="layui-card-body">
          <div style="padding-bottom: 10px;">
            <form name="searchform" action="<?php echo pfUrl('', 'protocol', 'index'); ?>" method="POST" class="layui-form" >
              <div class="layui-form layui-card-header layuiadmin-card-header-auto">
<!--                <div class="layui-form-item">
                  <label class="layui-form-label">协议名称：</label>
                  <div class="layui-input-inline">
                    <select name="protocol_id" lay-filter="louceng">
                      <option value="">请选择</option>
                      <?php foreach ($res as $key => $vo) {?>
                      <option value="<?=$vo['protocol_id']?>" <?php if($search['protocol_id']==$vo['protocol_id']) ECHO 'selected';?>><?=$vo['protocol_name']?></option>
                      <?php }?>
                    </select>
                  </div>
                  </div>-->
<!--                    <div class="layui-input-inline">
                      <input type="text" name="pro_name" class="layui-input" value="<?php echo $search['pro_name'] ?>" placeholder="协议名称" autocomplete="off">
                    </div>-->
<!--                  <div class="layui-inline">
                    <button class="layui-btn layuiadmin-btn-list" >
                      搜索
                    </button>
                  </div>
                  <div class="layui-inline">
                    <a class="layui-btn layuiadmin-btn-list" href="<?php echo pfUrl('', 'protocol', 'index'); ?>" >
                      重置
                    </a>
                  </div>-->
                  
                
                  <a class="layui-btn layuiadmin-btn-role" data-type="add" onclick="window.location.href = '<?php echo pfUrl("", "protocol", "edit")?>'">添加协议</a>
              </div>
            </form>
          </div>
          <div class="layui-form layui-border-box layui-table-view" lay-filter="LAY-table-4" lay-id="LAY-user-back-role" style=" ">
            <div class="layui-table-box">
              <div class="layui-table-body">
                <table cellspacing="0" cellpadding="0" border="0" class="layui-table" style="width:100%">
                  <thead>
<!--                  <tr>
                      <th data-field="id" data-key="4-0-2" class="layui-unselect" colspan="25" style="text-align:center;padding:15px 0;">
                        <h1><?= $_SESSION['school_name'].' '.$_SESSION['building_name'].' '.$_SESSION['floor_name'] ?></h1>
                      </th>
                    </tr>-->
                    <tr>
                      <th data-field="id" data-key="4-0-2" class=" layui-unselect">
                        <div class="layui-table-cell">
                          <span>协议ID</span>
                        </div>
                      </th>
                      <th data-field="id" data-key="4-0-2" class=" layui-unselect">
                        <div class="layui-table-cell">
                          <span>协议名称</span>
                        </div>
                      </th>
                      <th data-field="descr" data-key="4-0-4" class="">
                        <div class="layui-table-cell">
                          <span>协议脚本</span>
                        </div>
                      </th>
                      <th data-field="descr" data-key="4-0-4" class="">
                        <div class="layui-table-cell">
                          <span>协议状态</span>
                        </div>
                      </th>
                      <th data-field="descr" data-key="4-0-4" class="">
                        <div class="layui-table-cell">
                          <span>协议备注</span>
                        </div>
                      </th>
                      <th data-field="descr" data-key="4-0-4" class="">
                        <div class="layui-table-cell">
                          <span>更新时间</span>
                        </div>
                      </th>
                      <th data-field="descr" data-key="4-0-4" class="">
                        <div class="layui-table-cell">
                          <span>操作</span>
                        </div>
                      </th>
                    </tr>
                  </thead>
                  <tbody id="check_box">
                    <?php foreach ($lists as $ke => $vo) { ?>
                      <tr data-index="0" class="">
                        <td>
                          <div class="layui-table-cell"><?=$vo['protocol_id'] ?></div>
                        </td>
                        <td data-field="id" data-key="4-0-2" class="">
                          <div class="layui-table-cell"><?=$vo['protocol_name'] ?></div>
                        </td>
                        <td data-field="id" data-key="4-0-2" class="">
                          <div class="layui-table-cell"><?=$vo['protocol_script'] ?></div>
                        </td>
                        <td data-field="rolename" data-key="4-0-2" class="">
                          <div class="layui-table-cell"><?=$vo['protocol_publish']==1?'<span style="color:green">已发布</span>':'<span style="color:red">待发布</span>' ?></div>
                        </td>
                        <td data-field="rolename" data-key="4-0-2" class="">
                          <div class="layui-table-cell"><?=$vo['protocol_remark'] ?></div>
                        </td>
                        <td data-field="rolename" data-key="4-0-2" class="">
                          <div class="layui-table-cell"><?=$vo['protocol_ctime'] ?></div>
                        </td>
                        <td data-field="5" data-key="4-0-7" align="" data-off="true" class="layui-table-col-special">
                          <div class="layui-table-cell">
                              <?php if($vo['protocol_publish']==0){?>
                            <a class="layui-btn layui-btn-normal layui-btn-xs" href="javascript: if(window.confirm('你确定要发布吗?')) location.href='<?php echo pfUrl("", "protocol", "protocol_start", array("protocol_id" => $vo['protocol_id'],'publish'=>1)) ?>'">
                              <i class="layui-icon ">发布</i>
                            </a>
                              <?php }else{?>
                               <a class="layui-btn layui-btn-danger layui-btn-xs" href="javascript: if(window.confirm('你确定要禁止使用吗?')) location.href='<?php echo pfUrl("", "protocol", "protocol_start", array("protocol_id" => $vo['protocol_id'],'publish'=>0)) ?>'">
                              <i class="layui-icon ">禁用</i>
                            </a>
                              <?php } ?>
                            <a class="layui-btn layui-btn-normal layui-btn-xs" href="<?php echo pfUrl(" ", "protocol", "edit", array("protocol_id" => $vo['protocol_id'])) ?>">
                              <i class="layui-icon ">编辑</i>
                            </a>
                            <!-- <a class="layui-btn layui-btn-danger layui-btn-xs" href="javascript: if(window.confirm('你确定要删除该楼层吗?')) location.href='<?php echo pfUrl("", "protocol", "protocol_remove", array("protocol_id" => $vo['protocol_id'])) ?>'">
                              <i class="layui-icon ">删除</i>
                            </a> -->
                          </div>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
                <div class="dd-pages-wrap pc-m3">
                  <?php echo $pages; ?>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <script src="./attms/ms/layuiadmin/layui/layui.js"></script>  
    <script src="./attms/ms/js/jquery.min.js"></script>  
    <script>
      layui.config({
        base: './attms/ms/layuiadmin/' //静态资源所在路径
      }).extend({
        index: 'lib/index' //主入口模块
      }).use(['index', 'laydate', 'upload', 'form'], function () {

        var laydate = layui.laydate;
        var upload = layui.upload;
        var form = layui.form;
        //常规用法
        laydate.render({
          elem: '#test-laydate-normal-cn'
        });
        laydate.render({
          elem: '#test-laydate-normal-cn1'
        });
      
      });
    </script>
  </body>
</html>


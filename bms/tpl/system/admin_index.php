<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>物联网基础平台</title>
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
          <button class="layui-btn layuiadmin-btn-role" data-type="add" onclick="window.location.href='./index.php?c=system&a=admin_add'">添加管理员</button>
        </div>
      
<!--        <table id="LAY-user-back-role" lay-filter="LAY-user-back-role"></table>  -->
          <div class="layui-form layui-border-box layui-table-view" lay-filter="LAY-table-4" lay-id="LAY-user-back-role" style=" ">
              <div class="layui-table-box">
                  <div class="layui-table-body">
                      <table cellspacing="0" cellpadding="0" border="0" class="layui-table" style="width:100%">
                          <thead>
                              <tr>
                                 
                                  <th data-field="id" data-key="4-0-1" class=" layui-unselect">
                                      <div class="layui-table-cell laytable-cell-4-0-1">
                                          <span>ID</span>
                                      </div>
                                  </th>
                                  <th data-field="limits" data-key="4-0-3" class="">
                                      <div class="layui-table-cell laytable-cell-4-0-3">
                                          <span>管理员账号</span>
                                      </div>
                                  </th>
                                  <th data-field="limits" data-key="4-0-3" class="">
                                      <div class="layui-table-cell laytable-cell-4-0-3">
                                          <span>管理员名称</span>
                                      </div>
                                  </th>
                                  <th data-field="rolename" data-key="4-0-2" class="">
                                      <div class="layui-table-cell laytable-cell-4-0-2">
                                          <span>所属权限组</span>
                                      </div>
                                  </th>
                                  <th data-field="descr" data-key="4-0-4" class="">
                                      <div class="layui-table-cell laytable-cell-4-0-4">
                                          <span>状态</span>
                                      </div>
                                  </th>
                                  <th data-field="5" data-key="4-0-4" class=" layui-table-col-special">
                                      <div class="layui-table-cell laytable-cell-4-0-5" align="center">
                                          <span>操作</span>
                                      </div>
                                  </th>
                              </tr>
                          </thead>
                          <tbody id="check_box">
                              <?php foreach($re as $ke=>$vo){?>
                              <tr data-index="0" class="">
                                 
                                  <td data-field="id" data-key="4-0-1" class="">
                                      <div class="layui-table-cell laytable-cell-4-0-1"><?php echo $vo['admin_id']?></div>
                                  </td>
                                  <td data-field="limits" data-key="4-0-3" class="">
                                      <div class="layui-table-cell laytable-cell-4-0-3"><?php echo $vo['user_name']?></div>
                                  </td>
                                  <td data-field="limits" data-key="4-0-3" class="">
                                      <div class="layui-table-cell laytable-cell-4-0-3"><?php echo $vo['real_name']?></div>
                                  </td>
                                  <td data-field="rolename" data-key="4-0-2" class="">
                                      <div class="layui-table-cell laytable-cell-4-0-2"><?php echo $vo['roles']?></div>
                                  </td>
                                  <td data-field="descr" data-key="4-0-4" class="">
                                      <div class="layui-table-cell laytable-cell-4-0-4"><?php echo $vo['is_del']==0?'<span style="color:#008B00">正常</span>':'<span style="color:#e60014">禁止</span>'?></div>
                                  </td>
                                  <td data-field="5" data-key="4-0-4" align="" data-off="true" class="layui-table-col-special">
                                      <div class="layui-table-cell laytable-cell-4-0-4">
                                          <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit" href="./index.php?c=system&a=admin_add&admin_id=<?php echo $vo['admin_id']?>">
                                              编辑
                                          </a> 
                                          <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"  href="javascript: if(window.confirm('该管理员组确定要你删除吗?')) location.href='./index.php?c=system&a=admin_remove&admin_id=<?php echo $vo['admin_id']?>'">
                                              删除
                                          </a> 
                                      </div>
                                  </td>
                              </tr>
                              <?php }?>
                          </tbody>
                      </table>
                  </div>
                  </div>
          </div>

          
          
      </div>
    </div>
  </div>

 <script src="./attms/ms/layuiadmin/layui/layui.js"></script>  
  <script src="./attms/ms/js/jquery.min.js"></script>  
  <script>
 
  </script>
</body>
</html>


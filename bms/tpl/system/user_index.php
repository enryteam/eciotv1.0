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
          <button class="layui-btn layuiadmin-btn-role" data-type="add" onclick="window.location.href='./index.php?c=system&a=user_edit'">成员添加</button>
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
                                          <span>所属部门</span>
                                      </div>
                                  </th>
                                  <th data-field="limits" data-key="4-0-3" class="">
                                      <div class="layui-table-cell laytable-cell-4-0-3">
                                          <span>成员名称</span>
                                      </div>
                                  </th>
                                  <th data-field="limits" data-key="4-0-3" class="">
                                      <div class="layui-table-cell laytable-cell-4-0-3">
                                          <span>成员手机号</span>
                                      </div>
                                  </th>
                                  <th data-field="limits" data-key="4-0-3" class="">
                                      <div class="layui-table-cell laytable-cell-4-0-3">
                                          <span>成员地址</span>
                                      </div>
                                  </th>
                                  <th data-field="limits" data-key="4-0-3" class="">
                                      <div class="layui-table-cell laytable-cell-4-0-3">
                                          <span>设备管理</span>
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
                              <?php foreach($lists as $ke=>$vo){?>
                              <tr data-index="0" class="">
                                 
                                  <td data-field="id" data-key="4-0-1" class="">
                                      <div class="layui-table-cell laytable-cell-4-0-1"><?php echo $vo['id']?></div>
                                  </td>
                                  <td data-field="limits" data-key="4-0-3" class="">
                                      <div class="layui-table-cell laytable-cell-4-0-3"><?php echo $vo['department']?></div>
                                  </td>
                                  <td data-field="limits" data-key="4-0-3" class="">
                                      <div class="layui-table-cell laytable-cell-4-0-3"><?php echo $vo['user_name']?></div>
                                  </td>
                                  <td data-field="limits" data-key="4-0-3" class="">
                                      <div class="layui-table-cell laytable-cell-4-0-3"><?php echo $vo['phone']?></div>
                                  </td>
                                  <td data-field="limits" data-key="4-0-3" class="">
                                      <div class="layui-table-cell laytable-cell-4-0-3"><?php echo $vo['addr']?></div>
                                  </td>
                                  <td data-field="limits" data-key="4-0-3" class="">
                                      <div class="layui-table-cell laytable-cell-4-0-3"><?php echo $vo['is_service']==1?'是':'否'?></div>
                                  </td>
                                  
                                  <td data-field="5" data-key="4-0-4" align="" data-off="true" class="layui-table-col-special">
                                      <div class="layui-table-cell laytable-cell-4-0-4">
                                          <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit" href="./index.php?c=system&a=user_edit&id=<?php echo $vo['id']?>">
                                              编辑
                                          </a> 
                                          <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"  href="javascript: if(window.confirm('该管理员组确定要你删除吗?')) location.href='./index.php?c=system&a=user_remove&id=<?php echo $vo['id']?>'">
                                             删除
                                          </a> 
                                          <?php if($vo['is_service']==2){?>
                                          <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit" href="./index.php?c=system&a=user_service&id=<?php echo $vo['id']?>&is_service=1">
                                              设置
                                          </a> 
                                          <?php }elseif($vo['is_service']==1){?>
                                          <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"  href="./index.php?c=system&a=user_service&id=<?php echo $vo['id']?>&is_service=2">
                                             取消
                                          </a> 
                                          <?php } ?>
                                      </div>
                                  </td>
                              </tr>
                              <?php }?>
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
        function choose_pageSize() {
            var pageSize = $('.choose_pageSize').val();
            $.post('index.php', {c: 'index', a: 'pageSize', pageSize: pageSize}, function () {
            window.location.reload();
            });
        }
  </script>
</body>
</html>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>V3.0</title>
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
            <form name="searchform" action="#" method="POST">
              <div class="layui-form layui-card-header layuiadmin-card-header-auto">
                <div class="layui-form-item">
                  <a class="layui-btn layuiadmin-btn-role" data-type="add" onclick="window.location.href = '<?php echo pfUrl(" ", "gateway", "gateway_edit", array('school_id' => $school_id)) ?>'">添加网关</a>
                </div>
              </div>
            </form>
          </div>
          <div class="layui-form layui-border-box layui-table-view" lay-filter="LAY-table-4" lay-id="LAY-user-back-role" style=" ">
            <div class="layui-table-box">
              <div class="layui-table-header" style="overflow:auto; ">
                <table cellspacing="0" cellpadding="0" border="0" class="layui-table" style="width:100%">
                  <thead>
                    <tr>
                      <th data-field="id" data-key="4-0-1" class=" layui-unselect">
                  <div class="layui-table-cell">
                    <span>编号</span>
                  </div>
                  </th>
		 <th data-field="descr" data-key="4-0-4" class="">
                  <div class="layui-table-cell">
                    <span>企业代号</span>
                  </div>
                  </th>
                  <th data-field="descr" data-key="4-0-4" class="">
                  <div class="layui-table-cell">
                    <span>项目代号</span>
                  </div>
                  </th>
                  <th data-field="descr" data-key="4-0-4" class="">
                  <div class="layui-table-cell">
                    <span>网关SN</span>
                  </div>
                  </th>
                  <th data-field="descr" data-key="4-0-4" class="">
                  <div class="layui-table-cell">
                    <span>型号</span>
                  </div>
                  </th>
                  
                  <th data-field="descr" data-key="4-0-4" class="">
                  <div class="layui-table-cell laytable-cell-4-0-4">
                    <span>CLIENT_ID</span>
                  </div>
                  </th>
                  <th data-field="descr" data-key="4-0-4" class="">
                  <div class="layui-table-cell laytable-cell-4-0-4">
                    <span>TOPICKEY</span>
                  </div>
                  </th>
                  <th data-field="descr" data-key="4-0-4" class="">
                  <div class="layui-table-cell laytable-cell-4-0-4">
                    <span>TOPICVAL</span>
                  </div>
                  </th>
                  <th data-field="descr" data-key="4-0-4" class="">
                  <div class="layui-table-cell laytable-cell-4-0-4">
                    <span>注册时间</span>
                  </div>
                  </th>
                
                  <th data-field="5" data-key="4-0-5" class=" layui-table-col-special">
                  <div class="layui-table-cell " >
                    <span>操作</span>
                  </div>
                  </th>
                  </tr>
                  </thead>
                  <tbody id="check_box">
                    <?php foreach ($lists as $ke => $vo) { ?>
                      <tr data-index="0" class="">

                        <td data-field="id" data-key="4-0-1" class="">
                          <div class="layui-table-cell"><?php echo $vo['id'] ?></div>
                        </td>	
                        <td data-field="rolename" data-key="4-0-2" class="">
                          <div class="layui-table-cell"><?php echo $vo['company_code'] ?></div>
                        </td>
                        <td data-field="rolename" data-key="4-0-2" class="">
                          <div class="layui-table-cell"><?php echo $vo['project_code'] ?></div>
                        </td>
                        <td data-field="rolename" data-key="4-0-2" class="">
                          <div class="layui-table-cell"><?php echo $vo['sn'] ?></div>
                        </td>
                        <td data-field="rolename" data-key="4-0-2" class="">
                          <div class="layui-table-cell"><?php echo $vo['type'] ?></div>
                        </td>
                        <td data-field="rolename" data-key="4-0-2" class="">
                          <div class="layui-table-cell"><?php echo $vo['client_id'] ?></div>
                        </td>
                        <td data-field="rolename" data-key="4-0-2" class="">
                          <div class="layui-table-cell"><?php echo $vo['topic'] ?></div>
                        </td>
                        <td data-field="rolename" data-key="4-0-2" class="">
                          <div class="layui-table-cell"><?php echo $vo['up_topic'] ?></div>
                        </td>
                        <td data-field="rolename" data-key="4-0-2" class="">
                          <div class="layui-table-cell"><?= $vo['ctime'] ?></div>
                        </td>
                      
                        <td data-field="5" data-key="4-0-7" align="" data-off="true" class="layui-table-col-special">
                          <div class="layui-table-cell ">
                            <a class="layui-btn layui-btn-normal layui-btn-xs" href="<?php echo pfUrl(" ","gateway","gateway_edit",array("id"=>$vo['id']))?>">
                              <i class="layui-icon ">修改网关配置</i>
                            </a>
                             <a class="layui-btn layui-btn-normal layui-btn-xs" href="<?php echo pfUrl(" ","gateway","remove",array("gateway_id"=>$vo['id']))?>">
                              <i class="layui-icon ">删除网关</i>
                            </a> 
                            <?php if($vo['is_reg']==1){?>
                              <a class="layui-btn layui-btn-normal layui-btn-xs" href="<?php echo pfUrl(" ","gateway","gateway_reg",array("gateway_id"=>$vo['id'],'is_reg'=>2))?>">
                                <i class="layui-icon ">注册</i>
                              </a> 
                            <?php }else if($vo['is_reg']==2){?>
                              <a class="layui-btn layui-btn-danger layui-btn-xs" href="<?php echo pfUrl(" ","gateway","gateway_reg",array("gateway_id"=>$vo['id'],'is_reg'=>1))?>">
                                <i class="layui-icon ">取消注册</i>
                              </a> 
                            <?php } ?>
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
                }).use(['index', 'laydate', 'upload'], function () {

                  var laydate = layui.laydate;
                  var upload = layui.upload;
                  //常规用法
                  laydate.render({
                    elem: '#test-laydate-normal-cn'
                  });
                  laydate.render({
                    elem: '#test-laydate-normal-cn1'
                  });
                });
				
				function gateway_export(){
					var project_id=$('.project_id').val();
					window.location.href = './index.php?c=device&a=export_gateway&project_id='+project_id;
				
				}
                function is_freeze(id, type) {
  //     alert(id+'--'+type)
                  $.ajax({
                    type: 'POST',
                    url: './index.php?c=user&a=is_freeze',
                    dataType: 'json',
                    data: {id: id, type: type},
                    success: function (response)
                    {
                      console.log(response);
                      if (response.errorCode == 200) {
                        layer.msg(response.description);
                        window.location.reload();
                      } else {
                        layer.msg(response.description);
                      }
                    },
                    error: function (data)
                    {
                      layer.msg(data.description);
                    }
                  });
                }
                $('.close_show').click(function () {
                  $('.tan_show').hide();
                });
                function user_jf(id) {
                  $('.user_id').val(id);
                  $('.tan_show').show();
                }
                function user_submit() {
                  var user_id = $('.user_id').val();
                  var integral = $('.integral').val();
                  $.ajax({
                    type: 'POST',
                    url: './index.php?c=user&a=user_jf',
                    dataType: 'json',
                    data: {id: user_id, integral: integral},
                    success: function (response)
                    {
                      if (response.errorCode == 200) {
                        layer.msg(response.description);
                        window.location.reload();
                      } else {
                        layer.msg(response.description);
                      }
                    },
                    error: function (data)
                    {
                      layer.msg(data.description);
                    }
                  });
                }


                function chonzhi(id) {
                  $.ajax({
                    type: 'POST',
                    url: './index.php?c=user&a=user_chonzhi',
                    dataType: 'json',
                    data: {id: id},
                    success: function (response)
                    {
                      if (response.errorCode == 200) {
                        layer.msg(response.description);
                      } else {
                        layer.msg(response.description);
                      }
                    },
                    error: function (data)
                    {
                      layer.msg(data.description);
                    }
                  });
                }
                //导出
                function user_explode() {
                  var realname = $('.realname').val();
                  var phone = $('.phone').val();
                  var status = $('.status').val();
                  var type = $('.type').val();
                  window.location.href = "./index.php?c=user&a=user_explode&realname=" + realname + "&phone=" + phone + "&status=" + status + '&type=' + type;
                }

                function choose_pageSize() {
                  var pageSize = $('.choose_pageSize').val();
                  $.post('index.php', {c: 'index', a: 'pageSize', pageSize: pageSize}, function () {
                    window.location.reload();
                  });
                }
    </script>
  </body>
</html>


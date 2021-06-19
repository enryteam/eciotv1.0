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
            <form name="searchform" action="index.php?c=star&amp;a=index" method="POST">
               
                    <div class="layui-form layui-card-header layuiadmin-card-header-auto">
                      <div class="layui-form-item">
                           <?php //   if($count<1){ ?>
                        <a class="layui-btn layuiadmin-btn-role" data-type="add" onclick="window.location.href = '<?php echo pfUrl(" ", "product", "nature_edit",array('product_id'=>$r['id'])) ?>'">添加产品属性</a>
                          <?php //  } ?>
                         <a class="layui-btn layuiadmin-btn-role" style="background-color:#1E9FFF;" data-type="add" onclick="window.location.href = '<?php echo pfUrl(" ", "product", "index",array('page'=>$page)) ?>'">返回产品</a>
                      </div>
                    </div>
            </form>
          </div>
          <div class="layui-form layui-border-box layui-table-view" lay-filter="LAY-table-4" lay-id="LAY-user-back-role" style=" ">
            <div class="layui-table-box">
              <div class="layui-table-body" style="overflow:auto; ">
                <table cellspacing="0" cellpadding="0" border="0" class="layui-table" style="width:100%">
                    <caption style="height:40px;border-bottom: 1px #808080 solid ;"><?php echo $r['name'].'的属性'?></caption>
                  <thead>
                    <tr>
                  <th data-field="descr" data-key="4-0-4" class="">
                  <div class="layui-table-cell laytable-cell-4-0-4">
                    <span>字段名</span>
                  </div>
                  </th>
                  <th data-field="descr" data-key="4-0-4" class="">
                  <div class="layui-table-cell laytable-cell-4-0-4">
                    <span>字段注释</span>
                  </div>
                  </th>
                  <th data-field="descr" data-key="4-0-4" class="">
                  <div class="layui-table-cell laytable-cell-4-0-4">
                    <span>字段类型</span>
                  </div>
                  </th>
                  <th data-field="descr" data-key="4-0-4" class="">
                  <div class="layui-table-cell laytable-cell-4-0-4">
                    <span>默认值</span>
                  </div>
                  </th>
                  <th data-field="descr" data-key="4-0-4" class="">
                  <div class="layui-table-cell laytable-cell-4-0-4">
                    <span>小数点精度</span>
                  </div>
                  </th>
                  <th data-field="descr" data-key="4-0-4" class="">
                  <div class="layui-table-cell laytable-cell-4-0-4">
                    <span>属性说明</span>
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
                        <td data-field="id" data-key="4-0-2" class="">
                          <div class="layui-table-cell laytable-cell-4-0-2"><?php echo $vo['nature'] ?></div>
                        </td>
                        <td data-field="rolename" data-key="4-0-2" class="">
                          <div class="layui-table-cell laytable-cell-4-0-2"><?php echo $vo['nature_name'] ?></div>
                        </td>
                        <td data-field="rolename" data-key="4-0-2" class="">
                          <div class="layui-table-cell laytable-cell-4-0-2"><?php echo $vo['type'] ?></div>
                        </td>
                        <td data-field="rolename" data-key="4-0-2" class="">
                          <div class="layui-table-cell laytable-cell-4-0-2"><?php echo $vo['default_value'] ?></div>
                        </td>
                        <td data-field="rolename" data-key="4-0-2" class="">
                          <div class="layui-table-cell laytable-cell-4-0-2"><?php echo $vo['nature_float'] ?></div>
                        </td>
                        <td data-field="rolename" data-key="4-0-2" class="">
                          <div class="layui-table-cell laytable-cell-4-0-2"><?php echo $vo['remark'] ?></div>
                        </td>
                        <td data-field="5" data-key="4-0-7" align="" data-off="true" class="layui-table-col-special">
                          <div class="layui-table-cell ">
                            <a class="layui-btn layui-btn-normal layui-btn-xs" href="<?php echo pfUrl(" ","product","nature_edit",array("id"=>$vo['id'],'product_id'=>$vo['product_id'],'page'=>$page))?>">
                              <i class="layui-icon ">编辑</i>
                            </a>
                              <a class="layui-btn layui-btn-danger layui-btn-xs" href="<?php echo pfUrl(" ","product","nature_remove",array("id"=>$vo['id'],'product_id'=>$vo['product_id'],'page'=>$page))?>">
                              <i class="layui-icon ">删除</i>
                            </a>
                           
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


    <div style="text-align:center;display:none;" class="tan_show" >
      <div style="width:100%; height:900px;position:fixed; top :0px;background-color:#000;opacity:0.3;"></div>
      <div class="layui-layer layui-layer-page layui-layer-rim" id="layui-layer12" type="page" times="12" showtime="0" contype="string" style="position:absolute;z-index: 20; width: 450px; height: 220px; top: 219px; left: 394px;background-color: #fff;">

        <div class="layui-layer-title" style="cursor: move;font-size:17px;background: #ccc;height:35px;text-align:center;padding-top: 8px; ">赠送星光</div>
        <span class="layui-layer-setwin close_show" ><a class="layui-layer-ico layui-layer-close layui-layer-close1 pc-close-btn" href="###" style="display:block;"></a></span>
        <div id="" class="layui-layer-content" style="height: 197px;">
          <div style="padding: 10px;font-size:15px;margin-top: 20px;text-align:left;padding-left:5%;">
            <div class="layui-inline">
              <label >星光数量：</label>
              <div class="layui-input-inline">
                <input type="text" name="num" value="<?php echo $search['num'] ?>" placeholder="请输入" autocomplete="off" class="layui-input integral">
              </div>
            </div>
            <input type="hidden" id="user_id" class="user_id" value=""/>
          </div>
        </div>
        <div style="background-color: #007aff;width:80px;height:35px;line-height: 35px;position:absolute;bottom: 10px;right:10px;border: 1px #007aff solid;border-radius: 40px;color:#fff;" onclick="user_submit()">
          确认
        </div>
        <span class="layui-layer-resize"></span>
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


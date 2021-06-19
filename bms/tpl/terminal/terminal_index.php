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
          <div class="layui-form layui-card-header layuiadmin-card-header-auto">
            <form name="searchform" action="index.php?c=star&amp;a=index" method="POST">
              <div class="layui-form layui-card-header layuiadmin-card-header-auto">
              
                <div class="layui-form-item">
                  <a class="layui-btn layuiadmin-btn-role" data-type="add" onclick="window.location.href = '<?php echo pfUrl(" ", "terminal", "terminal_edit", array('gateway_id' => $gateway_id)) ?>'">添加设备</a>
                
                </div>
              </div>
            </form>
          </div>
          <div class="layui-form layui-border-box layui-table-view" lay-filter="LAY-table-4" lay-id="LAY-user-back-role" style=" ">
            <div class="layui-table-box">
              <div class="layui-table-body" style="overflow:auto; ">
                <table cellspacing="0" cellpadding="0" border="0" class="layui-table" style="width:100%">
                  <thead>
                    <tr>

                  <th data-field="id" data-key="4-0-1" class=" layui-unselect">
                    <div class="layui-table-cell laytable-cell-4-0-1">
                      <span>编号</span>
                    </div>
                  </th>
                  <th data-field="descr" data-key="4-0-4" class="">
                    <div class="layui-table-cell laytable-cell-4-0-4">
                      <span>设备名称</span>
                    </div>
                  </th>
                  <th data-field="descr" data-key="4-0-4" class="">
                  <div class="layui-table-cell laytable-cell-4-0-4">
                    <span>设备标识</span>
                  </div>
                  </th>
                 
                  <th data-field="descr" data-key="4-0-4" class="">
                  <div class="layui-table-cell laytable-cell-4-0-4">
                    <span>位置</span>
                  </div>
                  </th>
                  <th data-field="descr" data-key="4-0-4" class="">
                  <div class="layui-table-cell laytable-cell-4-0-4">
                    <span>所属网关</span>
                  </div>
                  </th>
                  <th data-field="descr" data-key="4-0-4" class="">
                  <div class="layui-table-cell laytable-cell-4-0-4">
                    <span>所属产品</span>
                  </div>
                  </th>
                 
                
                  <th data-field="descr" data-key="4-0-4" class="">
                  <div class="layui-table-cell laytable-cell-4-0-4">
                    <span>在线状态</span>
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
                          <div class="layui-table-cell laytable-cell-4-0-1"><?php echo $vo['id'] ?></div>
                        </td>
                        <td data-field="id" data-key="4-0-4" class="">
                          <div class="layui-table-cell laytable-cell-4-0-4"><?php echo $vo['name'] ?></div>
                        </td>
                        <td data-field="rolename" data-key="4-0-2" class="">
                          <div class="layui-table-cell laytable-cell-4-0-2"><?php echo $vo['sn'] ?></div>
                        </td>
                      
                        <td data-field="rolename" data-key="4-0-2" class="">
                          <div class="layui-table-cell laytable-cell-4-0-2"><?php echo $vo['addr'] ?></div>
                        </td>
                        <td data-field="rolename" data-key="4-0-2" class="">
                          <div class="layui-table-cell laytable-cell-4-0-2"><?php echo $vo['gateway_name'] ?></div>
                        </td>
                        <td data-field="rolename" data-key="4-0-2" class="">
                          <div class="layui-table-cell laytable-cell-4-0-2"><?php echo $vo['product_name'] ?></div>
                        </td>
                       
                      
                        <td data-field="rolename" data-key="4-0-2" class="">
                          <div class="layui-table-cell laytable-cell-4-0-2"><?php echo $vo['online']==1?'<span style="color:green;">在线</span>':'<span style="color:red;">离线</span>' ?></div>
                        </td>
                      
                        <td data-field="5" data-key="4-0-7" align="" data-off="true" class="layui-table-col-special">
                          <div class="layui-table-cell ">
                            <a class="layui-btn layui-btn-normal layui-btn-xs" href="<?php echo pfUrl(" ","terminal","terminal_edit",array("id"=>$vo['id'],'gateway_id'=>$gateway_id))?>">
                              <i class="layui-icon ">编辑</i>
                            </a>
                            <?php if($vo['is_disable']==1){?>
                            <a class="layui-btn layui-btn-danger layui-btn-xs" href="<?php echo pfUrl(" ","terminal","terminal_remove",array("id"=>$vo['id'],'is_disable'=>2))?>">
                                            <i class="layui-icon ">禁用</i>
                                          </a>
                            <?php }else{ ?>
                              <a class="layui-btn layui-btn-normal layui-btn-xs" href="<?php echo pfUrl(" ","terminal","terminal_remove",array("id"=>$vo['id'],'is_disable'=>1))?>">
                                <i class="layui-icon ">激活</i>
                              </a>
                            <?php }?>
                               <a class="layui-btn  layui-btn-xs debug " data-id="<?php echo $vo['id']?>" data-name="<?php echo $vo['name']?>" data-product_id="<?php echo $vo['product_id']?>" style="background-color:#009688;" href="###" >
                              <i class="layui-icon ">调试</i>
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

        <div class="layui-layer-title" style="cursor: move;font-size:17px;background: #ccc;height:35px;text-align:center;padding-top: 8px; ">产品功能调试</div>
        <span class="layui-layer-setwin close_show" ><a class="layui-layer-ico layui-layer-close layui-layer-close1 pc-close-btn" href="###" style="display:block;"></a></span>
        <div id="" class="layui-layer-content" style="height: 197px;">
          <div style="padding: 10px;font-size:15px;margin-top: 20px;text-align:left;padding-left:5%;">
            <div class="layui-inline">
              <label >功能 调试：</label>
              <div class="layui-input-inline">
                <!-- <input type="text" name="num" value="<?php echo $search['num'] ?>" placeholder="请输入" autocomplete="off" class="layui-input integral"> -->
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

                  $('.debug').on('click',function (){
                    var terminal_name=$(this).attr('data-name');
                    var id=$(this).attr('data-id');
                    var product_id=$(this).attr('data-product_id');
                    console.log(id+'^^^^^^'+terminal_name+'&&&&'+product_id);
                    layer.open({
                        type: 2
                        ,title: terminal_name+'的设备调试'
                        ,content: './index.php?c=terminal&a=lists&product_id='+product_id+'&id='+id
                        ,maxmin: true
                        ,area: ['1000px', '550px']
                        // ,btn: ['确定', '取消']
                        ,yes: function(index, layero){
                           layer.closeAll();
                        }

                      });
                  });


                });
                
                

                $('.close_show').on('click',function (){
                  $('.tan_show').hide();
                });

                function terminal_synchro() {
                  var gateway_id = $('.gateway_id').val();
                  layer.msg(gateway_id);
                  $.ajax({
                    type: 'POST',
                    url: './index.php?c=terminal&a=terminal_synchro',
                    dataType: 'json',
                    data: {gateway_id:gateway_id},
                    success: function (response)
                    {
                      if (response.errorCode == 200) {
                        layer.msg(response.description);
                        console.log(response.data.sqlite_url);
                        //开始下达指令 下载数据库response.data.sqlite_url
                        //数据库路径 需要序列化
                        var downurl=encodeURI(response.data.sqlite_url);
                          $.ajax({
                            type: 'POST',
                            url: './index.php?c=terminal&a=terminal_download',
                            dataType: 'json',
                            data: {gateway_id:gateway_id,downurl:downurl},
                            success: function (response)
                            {
                              if (response.errorCode == 200) {
                              } else {
                                layer.msg(response.description);
                              }
                            },
                            error: function (data)
                            {
                            }
                          });
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


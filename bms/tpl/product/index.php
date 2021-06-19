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
                  <a class="layui-btn layuiadmin-btn-role" data-type="add" onclick="window.location.href = '<?php echo pfUrl(" ", "product", "edit") ?>'">添加产品</a>
				   <!-- <a class="layui-btn layuiadmin-btn-role" data-type="add" onclick="newsubmit()">重载物模型</a> -->
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
                    <span>产品名称</span>
                  </div>
                  </th>
                 
                  <th data-field="descr" data-key="4-0-4" class="">
                  <div class="layui-table-cell laytable-cell-4-0-4">
                    <span>产品类别</span>
                  </div>
                  </th>
                  <th data-field="descr" data-key="4-0-4" class="">
                  <div class="layui-table-cell laytable-cell-4-0-4">
                    <span>设备类型</span>
                  </div>
                  </th>
                  <th data-field="descr" data-key="4-0-4" class="">
                  <div class="layui-table-cell laytable-cell-4-0-4">
                    <span>通信类型</span>
                  </div>
                  </th>
                 
                  <th data-field="descr" data-key="4-0-4" class="">
                  <div class="layui-table-cell laytable-cell-4-0-4">
                    <span>说明</span>
                  </div>
                  </th>
                  <th data-field="5" data-key="4-0-5" class=" layui-table-col-special">
                  <div class="layui-table-cell " >
                    <span>物模型</span>
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
                        <td data-field="id" data-key="4-0-2" class="">
                          <div class="layui-table-cell laytable-cell-4-0-2"><?php echo $vo['name'] ?></div>
                        </td>
                        
                        <td data-field="rolename" data-key="4-0-2" class="">
                          <div class="layui-table-cell laytable-cell-4-0-2"><?php echo $vo['cate_title'] ?></div>
                        </td>
                        <td data-field="rolename" data-key="4-0-2" class="">
                          <div class="layui-table-cell laytable-cell-4-0-2"><?php echo $vo['is_connect']>0?'':$vo['is_connect']==1?'直连设备':'网关子设备' ?></div>
                        </td>
                        <td data-field="rolename" data-key="4-0-2" class="">
                          <div class="layui-table-cell laytable-cell-4-0-2">
                          <?php 
                          if($vo['iottype']==1) echo 'Rs485';
                          elseif($vo['iottype']==2) echo 'ZigBee';
                          elseif($vo['iottype']==3) echo 'Lora';
                          elseif($vo['iottype']==4) echo 'Wifi';
                          elseif($vo['iottype']==5) echo '4G';
                          ?></div>
                        </td>
                       
                        <td data-field="rolename" data-key="4-0-2" class="">
                          <div class="layui-table-cell laytable-cell-4-0-2"><?php echo $vo['remark'] ?></div>
                        </td>
                        <td data-field="5" data-key="4-0-7" align="" data-off="true" class="layui-table-col-special">
                          <div class="layui-table-cell ">
                            <a class="layui-btn  layui-btn-xs" href="<?php echo pfUrl(" ","product","nature",array("product_id"=>$vo['id'],'page'=>$page))?>">
                                <i class="layui-icon ">属性</i>
                            </a>
                            <a class="layui-btn layui-btn-normal layui-btn-xs" href="<?php echo pfUrl(" ","product","product_edit",array("product_id"=>$vo['id'],'page'=>$page))?>"   >
                                <i class="layui-icon ">功能</i>
                            </a>
                            <a class="layui-btn layui-btn-normal layui-btn-xs" href="<?php echo pfUrl(" ","product","gateway_state",array("product_id"=>$vo['id'],'page'=>$page))?>">
                                    <i class="layui-icon ">事件</i>
                            </a>
                          </div>
                        </td>
                        <td data-field="5" data-key="4-0-7" align="" data-off="true" class="layui-table-col-special">
                          <div class="layui-table-cell ">
                            <a class="layui-btn layui-btn-normal layui-btn-xs" href="<?php echo pfUrl(" ","product","edit",array("id"=>$vo['id'],'page'=>$page))?>">
                              <i class="layui-icon ">编辑</i>
                            </a>
                              <a class="layui-btn layui-btn-danger layui-btn-xs" href="<?php echo pfUrl(" ","product","remove",array("id"=>$vo['id'],'page'=>$page))?>">
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
      <div class="layui-layer layui-layer-page layui-layer-rim" id="layui-layer12" type="page" times="12" showtime="0" contype="string" style="position:absolute;z-index: 20; width: 550px; height: 450px; top: 10px; left: 294px;background-color: #fff;">

        <div class="layui-layer-title" style="cursor: move;font-size:17px;background: #ccc;height:35px;text-align:center;padding-top: 8px; ">功能</div>
        <span class="layui-layer-setwin close_show" ><a class="layui-layer-ico layui-layer-close layui-layer-close1 pc-close-btn" href="###" style="display:block;"></a></span>
        <div id="" class="layui-layer-content" style="height: 400px;">
            <button type="button" class="layui-btn layui-btn-primary" id="test-upload-type2" style="magin-top:15px;position: absolute;right:10px;top:10px;">脚本编辑</button>	  
          <div style="padding: 10px;font-size:15px;margin-top: 40px;text-align:left;padding-left:5%;">
            <div class="layui-inline">
              <label >功能：</label>
              <div class="layui-input-inline">
<!--                <textarea name="content" placeholder="请输入" class="layui-textarea content" style="width:400px;height:300px;"></textarea>-->
               <?php
                   $cfile="./eciot_product_".$product_id.".php";
                   $cfilehandle=fopen($cfile,"r");
                    $editfile=fread($cfilehandle,filesize($cfile));
                    fclose($cfilehandle);
                    echo"<form active='?' method='post'>";
                    echo"<textarea cols='100%' rows='30' name='copy' id='code'>";
                    echo $editfile;
                    echo"</textarea>";
                    echo"<p><input type='submit' value='提交' name='edit'></p ></form>";
                    ?>   
              </div>
            </div>
            <input type="hidden" id="product_id" class="product_id" value=""/>
          </div>
        </div>
        <div style="background-color: #007aff;width:80px;height:35px;line-height: 35px;position:absolute;bottom: 10px;right:10px;border: 1px #007aff solid;border-radius: 40px;color:#fff;" onclick="user_submit()">
          确认
        </div>
        <span class="layui-layer-resize  file_addr"></span>
      </div>
    </div>

    <script src="./attms/ms/layuiadmin/layui/layui.js"></script>  
    <script src="./attms/ms/js/jquery.min.js"></script>  
    <script>
            var xmlhttp;
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
                  
              
                  upload.render({ //允许上传的文件后缀
                    elem: '#test-upload-type2'
                    ,url: './index.php?c=product&a=ability'
                    ,accept: 'file' //普通文件
                    ,exts: 'zip|rar|php|txt' //只允许上传压缩文件
                    ,done: function(res){
                          console.log(res);
                           console.log(res.data.file_txt);
                           if(res.errorCode==200){
                               $('.file_addr').html(res.data.file_txt);
                               
                                loadData(res.data.file_txt, function () {
                                    console.log('读取的数据 ==== ', xmlhttp);
                                    
                                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                                      console.log('读取的数据 ==== ', xmlhttp.responseText);
                                      $('.content').val(xmlhttp.responseText);
                                    } else {
                                       $('.content').val('');
                                    }
                                  })
                               layer.msg(res.description);
                           }else{
                               layer.msg(res.description);
                           }
                           
                    }
                  });
                });

			function newsubmit(){
				$.ajax({
                    type: 'POST',
                    url: './index.php?c=product&a=reload',
                    dataType: 'json',
                    data: {},
                    success: function (response)
                    {
                      console.log(response);
                      if (response.errorCode == 200) {
                         
                        layer.msg(response.description);
                        //window.location.reload();
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

            function loadData(url, cfunc) {
              if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
              } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
              }
              xmlhttp.onreadystatechange = cfunc;
              xmlhttp.open("GET", url, true);
              xmlhttp.send();
            };  
                function gongneng(id){
                    $('.tan_show').show();
                    $('.product_id').val(id);
                }
                $('.close_show').on('click',function(){
                     $('.tan_show').hide();
                });
               function user_submit(){
                   var product_id= $('.product_id').val();
                   var file_addr= $('.file_addr').html();
                    $.ajax({
                    type: 'POST',
                    url: './index.php?c=product&a=ability_port',
                    dataType: 'json',
                    data: {product_id:product_id,file_addr: file_addr},
                    success: function (response)
                    {
                      console.log(response);
                      if (response.errorCode == 200) {
                           $('.tan_show').hide();
                        layer.msg(response.description);
                        //window.location.reload();
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
                function user_jf(id) {
                  $('.user_id').val(id);
                  $('.tan_show').show();
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


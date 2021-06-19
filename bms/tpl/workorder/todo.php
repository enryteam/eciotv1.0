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

      .box_ul, .box_ul li{
          list-style:none; /* 将默认的列表符号去掉 */
            padding:0; /* 将默认的内边距去掉 */
            margin:0; /* 将默认的外边距去掉 */
      }
      .box_ul li{
        float:left; /* 往左浮动 */
      }
      .lay_box_lable{
            text-decoration: none;
            margin: 0px;
            display: block; /* 作为一个块 */
            height:30px;
            line-height:30px;
            /*text-align:center;*/
      }
       .lay_box_lable1{
            text-decoration: none;
            margin: 0px;
            display: block; /* 作为一个块 */
            width:90px;
            height:30px;
            line-height:30px;
           text-align:left;
      }
      .layui-form-checkbox, .layui-form-checkbox *, .layui-form-switch {
          display: none;
          vertical-align: middle;
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
              <!-- <a class="layui-btn layuiadmin-btn-role" data-type="add" onclick="window.location.href='./index.php?c=workorder&a=warn_edit'"></a> -->
                <div class="layui-form-item">	
                  <div class="layui-inline">
                    <label class="layui-form-label" style="text-align:left;width:30px;">设备名称</label>
                    <div class="layui-input-inline">
                        <input type="text" name="terminal_name" value="<?php echo $search['terminal_name']?>" placeholder="请输入" autocomplete="off" class="layui-input terminal_name">
                    </div>
                  </div>
                  <div class="layui-inline">
                    <label class="layui-form-label" style="text-align:left;width:30px;">设备状态</label>
                    <div class="layui-input-inline">
                        <select name="type" class="type" style="">
                        <option value=''>请选择</option>
                        <option value="1"  <?php if($search['type']==1) echo 'selected';?>>维修</option>
                        <option value="2"  <?php if($search['type']==2) echo 'selected';?>>告警</option>
                      </select>
                    </div>
                  </div>
                
                  <div class="layui-inline">
                    <label class="layui-form-label" style="text-align:left;width:30px;">是否网关</label>
                    <div class="layui-input-inline">
                        <select name="is_device" class="is_device" style="">
                        <option value=''>请选择</option>
                        <option value="1"  <?php if($search['is_device']==1) echo 'selected';?>>设备故障</option>
                        <option value="2"  <?php if($search['is_device']==2) echo 'selected';?>>网关故障</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="layui-form-item">	
                  <div class="layui-inline">
                    <label class="layui-form-label" style="text-align:left;width:30px;">工单状态</label>
                    <div class="layui-input-inline">
                        <select name="status" class="status" style="">
                        <option value=''>请选择</option>
                        <option value="1"  <?php if($search['status']==1) echo 'selected';?>>待执行</option>
                        <option value="2"  <?php if($search['status']==2) echo 'selected';?>>处理中</option>
                        <option value="3"  <?php if($search['status']==3) echo 'selected';?>>已完成</option>
                        <option value="4"  <?php if($search['status']==4) echo 'selected';?>>已拒绝</option>
                      </select>
                    </div>
                  </div>
                  <div class="layui-inline" >
                    <div class="layui-input-inline" >
                      <div style="margin-top:-20px;">
                        <input type="submit" value="搜索" class="layui-btn layuiadmin-btn-role">
                        <a class="layui-btn layuiadmin-btn-role" data-type="add" onclick="window.location.href='./index.php?c=workorder&a=todo'">重置</a>
                      </div>
                   </div>
                  </div>
                    
                     <div class="layui-inline">
                        <label class="layui-form-label" style="text-align:left;width:30px;">成员</label>
                      <div class="layui-input-inline">
                          <select name="user_id" class="user_id" >
                          <option value=''>请选择</option>
                          <?php foreach($user as $ke=>$vo){?>
                          <option value="<?php echo $vo['id']?>"<?php if($search['user_id']==$vo['id']) echo 'selected';?>><?php echo $vo['user_name']?></option>
                          <?php } ?>
                        </select>
                      </div>
                      <a class="layui-btn layuiadmin-btn-role assign_terminal " style="left:10px;margin-top:-5px;" data-type="add" >指派</a>
                  </div>
                    
                  </div>
                  
              </div>
              </div>
            </form>
          </div>
          <div class="layui-form layui-border-box layui-table-view" lay-filter="LAY-table-4" lay-id="LAY-user-back-role" style=" ">
            <div class="layui-table-box">
              <div class="layui-table-body" style="overflow:auto; ">
                <table cellspacing="0" cellpadding="0" border="0" class="layui-table" style="width:100%">
                  <thead>
                  <th data-field="limits" data-key="4-0-3" class="" style="width:3%">
                      <div class="layui-table-cell">
                          <ul class="box_ul">
                              <li><lable class="lay_box_lable"> <input type="checkbox" name="box_name"  class="chenckboxall" style="display:inline;width:17px;height:17px;margin-top:-3px;vertical-align:middle;"></lable></li>
                          </ul>
                      </div>
                  </th>

                  <th data-field="id" data-key="4-0-1" class=" layui-unselect">
                    <div class="layui-table-cell">
                      <span>编号</span>
                    </div>
                  </th>
                  <th data-field="descr" data-key="4-0-4" class="">
                  <div class="layui-table-cell">
                    <span>产品名称</span>
                  </div>
                  </th>
                  <th data-field="descr" data-key="4-0-4" class="">
                  <div class="layui-table-cell">
                    <span>设备名称</span>
                  </div>
                  </th>
                  <th data-field="descr" data-key="4-0-4" class="">
                  <div class="layui-table-cell">
                    <span>是否网关</span>
                  </div>
                  </th>
                  <th data-field="descr" data-key="4-0-4" class="">
                  <div class="layui-table-cell">
                    <span>是否故障</span>
                  </div>
                  </th>
                  <th data-field="descr" data-key="4-0-4" class="">
                  <div class="layui-table-cell laytable-cell-4-0-4">
                    <span>处理状态</span>
                  </div>
                  </th>
                   <th data-field="descr" data-key="4-0-4" class="">
                  <div class="layui-table-cell laytable-cell-4-0-4">
                    <span>创建时间</span>
                  </div>
                  </th>
                  <th data-field="descr" data-key="4-0-4" class="">
                  <div class="layui-table-cell">
                    <span>完成日期</span>
                  </div>
                  </th>
                  <th data-field="descr" data-key="4-0-4" class="">
                  <div class="layui-table-cell">
                    <span>提交人</span>
                  </div>
                  </th>
                  <th data-field="descr" data-key="4-0-4" class="">
                  <div class="layui-table-cell">
                    <span>接受人</span>
                  </div>
                  </th>
                  <th data-field="descr" data-key="4-0-4" class="">
                  <div class="layui-table-cell">
                    <span>指派人</span>
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
                        <td data-field="id"  class="">
                          <div class="layui-table-cell " style="height:auto;" >
                              <ul class="box_ul">
                                  <li><lable class="lay_box_lable"> <input type="checkbox" name="box_name[]" <?php if(in_array($vo['id'],$yids)) echo 'checked'?> value="<?php echo $vo['id']?>" class="checkone <?php if(in_array($vo['id'],$yids)) echo 'on' ?>" data-id="<?php echo $vo['id']?>" style="display:inline;width:17px;height:17px;margin-top:-3px;vertical-align:middle;"></lable></li>
                              </ul>
                            </div>
                        </td>
                        <td data-field="id" data-key="4-0-1" class="">
                          <div class="layui-table-cell"><?php echo $vo['id'] ?></div>
                        </td>
                        <td data-field="rolename" data-key="4-0-2" class="">
                          <div class="layui-table-cell"><?php echo $vo['product_name'] ?></div>
                        </td>
                        <td data-field="rolename" data-key="4-0-2" class="">
                          <div class="layui-table-cell"><?php echo $vo['terminal_name'] ?></div>
                        </td>
                        <td data-field="rolename" data-key="4-0-2" class="">
                          <div class="layui-table-cell"><?php echo $vo['is_device']==1?'设备':'网关'; ?></div>
                        </td>
                        <td data-field="rolename" data-key="4-0-2" class="">
                          <div class="layui-table-cell"><?php echo $vo['type']==1?'维修':'故障'; ?></div>
                        </td>
                        <td data-field="rolename" data-key="4-0-2" class="">
                          <div class="layui-table-cell">
                          <?php  
                          if($vo['status']==1) echo '待执行';
                          elseif($vo['status']==2) echo '处理中';
                          elseif($vo['status']==3) echo '已完成';
                          elseif($vo['status']==4) echo '已拒绝';
                           ?></div>
                        </td>
                        <td data-field="rolename" data-key="4-0-2" class="">
                          <div class="layui-table-cell"><?= $vo['ctime'] ?></div>
                        </td>
                        <td data-field="rolename" data-key="4-0-2" class="">
                          <div class="layui-table-cell"><?= $vo['day']?></div>
                        </td>
                        <td data-field="rolename" data-key="4-0-2" class="">
                          <div class="layui-table-cell"><?php echo $vo['admin_name']?></div>
                        </td>
                        <td data-field="rolename" data-key="4-0-2" class="">
                          <div class="layui-table-cell"><?php echo $vo['user_name']?></div>
                        </td>
                        <td data-field="rolename" data-key="4-0-2" class="">
                          <div class="layui-table-cell"><?php echo $vo['assign_name']?></div>
                        </td>
                       <td data-field="5" data-key="4-0-7" align="" data-off="true" class="layui-table-col-special">
                          <div class="layui-table-cell ">
                            <!-- <a class="layui-btn layui-btn-normal layui-btn-xs" href="<?php echo pfUrl(" ","workorder","warn_edit",array("id"=>$vo['workorder_id']))?>">
                              <i class="layui-icon ">编辑</i>
                            </a> -->
                            <!-- <a class="layui-btn layui-btn-normal layui-btn-xs" href="<?php echo pfUrl(" ","workorder","warn_assign",array("workorder_id"=>$vo['id']))?>">
                              <i class="layui-icon ">指派</i>
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
        <span style="display:none;" class="terminal_id"></span>
      </div>
    </div>

    <script src="./attms/ms/layuiadmin/layui/layui.js"></script>  
    <script src="./attms/ms/js/jquery.min.js"></script>  
    <script>
          layui.config({
            base: './attms/ms/layuiadmin/' //静态资源所在路径
          }).extend({
            index: 'lib/index' //主入口模块
          }).use(['index', 'laydate','table', 'upload'], function () {

            var laydate = layui.laydate;
            var upload = layui.upload;
            var form=layui.form;
            //常规用法
            laydate.render({
              elem: '#test-laydate-normal-cn'
            });
            laydate.render({
              elem: '#test-laydate-normal-cn1'
            });
            form.render('select');
          upload.render({ //允许上传的文件后缀
            elem: '#test-upload-type2'
            ,url: './index.php?c=workorder&a=workorder_import'
            ,accept: 'file' //普通文件
            ,exts: 'zip|rar|7z|json' //只允许上传压缩文件
            ,done: function(res){
                  window.location.reload();
                  console.log(res);
                    /*if (response.errorCode == 200) {
                          layer.msg(response.description);
                          window.location.reload();
                    } else {
                          layer.msg(response.description);
                    }
                    */
              }
          });
          
          $("#test-upload-type3").on('click',function (){
            $.ajax({
              type: 'POST',
              url: '../../service/core/eciot3s_online_status.php',
              dataType: 'json',
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
          });
        });

        $('.assign_terminal').on('click',function(){
            var ids=$('.terminal_id').html();
            var user_id=$('.user_id').val();
            $.ajax({
              type: 'POST',
              url: './index.php?c=workorder&a=todo_lists&user_id='+user_id+"&terminal_ids="+ids,
              dataType: 'json',
              success: function (response)
              {
                console.log(response);
                if (response.errorCode == 200) {
                  layer.msg(response.description);
                  setTimeout(() => {
                    window.location.reload();
                  }, 1500);
                 
                } else {
                  layer.msg(response.description);
                }
              },
              error: function (data)
              {
                layer.msg(data.description);
              }
            });
        });


        /////  *********   *******  /
        
        $('.chenckboxall').change(function(){
            $(this).is(':checked');
            var ones=$('.chenckboxall').hasClass('one');
            if(ones){
                  $('.chenckboxall').removeClass('one');
                  $('.checkone').removeClass('on');
                  var check_list = document.getElementsByName("box_name[]");
                for(var i = 0; i < check_list.length; i++)
                 {
                        check_list[i].checked = false;
                  }
            }else{
                $(this).addClass('one');
                $('.checkone').addClass('on');
                var check_list = document.getElementsByName("box_name[]");
              for(var i = 0; i < check_list.length; i++)
                {
                    check_list[i].checked = true;
                }
            }
            //获取明星ID 数据
            var arr=[];
            var $elements = $('.checkone');
            var len = $elements.length;
            $elements.each(function() {
                    var active=$(this).hasClass("on")
                    if(active){
                        var id=$(this).attr('data-id');
                        arr.push(id);
                    }
            });
            // console.log(arr);
             var aaa=arr.join(',');
             console.log(aaa+'---MMMMM---');
             $('.terminal_id').html(aaa);
            //  localStorage.aaa=aaa;
        });
        $('.checkone').change(function (){
            var on=$(this).hasClass('on');
            var id=$(this).attr('data-id');
            console.log(id+'-----YYYY---');
             if(on){
                 $(this).removeClass('on');
             }else{
                 $(this).addClass('on');
             }
            var type = $(this).is(':checked');
            var arr=[];
            var $elements = $('.checkone');
            var len = $elements.length;
            $elements.each(function() {
                    var active=$(this).hasClass("on")
                    if(active){
                        var id=$(this).attr('data-id');
                        arr.push(id);
                    }
            });
            var aaa=arr.join(',');
            $('.terminal_id').html(aaa);
             localStorage.aaa=aaa;
            console.log(aaa+'---MMMMM---');
            
         })

          
         


          
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


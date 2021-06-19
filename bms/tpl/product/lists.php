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

  <style>
  /* 这段样式只是用于演示 */
  #LAY-component-grid-list .demo-list .layui-card{height: 70px;width:55px;}
  .layui-col-lg2{
    width:6.66667%;
    /* display:none; */
  }
  </style>

  <div class="layui-fluid" id="LAY-component-grid-list">
    <div class="layui-row layui-col-space10 demo-list">
     <?php foreach($lists as $ke=>$vo){ ?>
      <div class="layui-col-sm4 layui-col-md3 layui-col-lg2 product_icon" data-img="<?php echo $vo['icon_img'];?>"  >
        <!-- 填充内容 -->
        <div class="layui-card" style="" >
          <img src="<?php echo $vo['icon_img']?>" style="width:45px;height:60px;margin-left:3px;" >
        </div>
        <div class="icon_style" style="display:none;color:green;position:absolute;margin-top:-35px;margin-left:35px;font-size:16px;">
          ✔
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
    <script src="./attms/ms/layuiadmin/layui/layui.js"></script>  
    <script src="./attms/ms/js/jquery.min.js"></script>  
    <script>
        var xmlhttp;
        var ids='';
            layui.config({
              base: './attms/ms/layuiadmin/' //静态资源所在路径
            }).extend({
              index: 'lib/index' //主入口模块
            }).use(['index', 'laydate', 'upload','form'], function () {

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
                $('.product_icon').on('click',function(){
                    var icon_img=$(this).attr('data-img');
                    $('.icon_style').hide();
                    $(this).find('.icon_style').show();
                    localStorage.setItem("icon_img",icon_img);
                });
                
            });
            function product_icon(id){
                localStorage.setItem("icon_id",id);
            }
		
    </script>
  </body>
</html>


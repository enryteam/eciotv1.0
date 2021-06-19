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
      .aaaa{
        position:absolute;
        left:15%;
        top:0px;
        font-size:15px;

      }
      .sex_input1{
        position:absolute;
        left:7%;
        top:1px;
        font-size:15px;

      }
      .sex_input2{
        position:absolute;
        left:10.5%;
        top:1px;
        font-size:15px;

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
        height:38px;
        line-height:38px;
        /*text-align:center;*/
      }
      #div1{text-align:left;width: 700px;height: 38px;}
      .div2{display: inline-block;padding-left: 3px;padding-right:17px;margin-left: 3px;margin-right:17px;}

    </style>
  </head>
  <body>

    <div class="layui-fluid">   
      <div class="layui-card">
        <div style="height:20px;"></div>
        <form action="<?php echo pfurl('', 'admininfo', 'change_pwd'); ?>" method="post" class="layui-form">
          <div class="layui-form-item">
            <label class="layui-form-label">当前密码：</label>
            <div class="layui-input-inline">
              <input type="password" name="old_password" value="" lay-verify="name" autocomplete="off" placeholder="请输入" class="layui-input"  style="width:200px;height:38px;"  id="currPassword"><span id='sp1' style="color:orange"></span>
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">新密码：</label>
            <div class="layui-input-inline">
              <input id="newPassword_1" type="password" name="password1" value="" lay-verify="name" autocomplete="off" placeholder="请输入" class="layui-input"  style="width:200px;height:38px;"><span id='sp2' style="color:orange"></span>
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">确认密码：</label>
            <div class="layui-input-inline">
              <input id="newPassword_2" type="password" name="password2" value="" lay-verify="name" autocomplete="off" placeholder="请输入" class="layui-input"  style="width:200px;height:38px;"><span id='sp3' style="color:orange"></span>
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label"></label>
            <div class="layui-input-inline">
              <button class="layui-btn" lay-submit lay-filter="component-form-demo1">立即修改</button>
            </div>
          </div>
          <div style="height:20px;"></div>
        </form>
      </div>
    </div>

    <script src="./attms/ms/layuiadmin/layui/layui.js"></script>  
    <script src="./attms/ms/js/jquery.min.js"></script>  
    <script>
      layui.config({
        base: './attms/ms/layuiadmin/' //静态资源所在路径
      }).extend({
        index: 'lib/index' //主入口模块
      }).use(['index', 'laydate', 'form', 'upload'], function () {

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


        /* 监听提交 */
        form.on('submit(component-form-demo1)', function (data) {
          var pwd=$('#currPassword').val();
          var pwd1 = $('#newPassword_1').val();
          var pwd2 = $('#newPassword_2').val();
          if(pwd){
            if(pwd1==pwd2 && pwd1){
              $('form').submit();
            }else{
              layer.msg("两次输入密码不一致, 请重新输入");
              return false;
            }
          }else{
            layer.msg("未输入原密码, 请输入");
              return false;
          }
        });
      });
    </script>
  </body>
</html>


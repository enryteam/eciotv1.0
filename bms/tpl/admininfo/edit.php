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
        <form action="<?php echo pfurl('', 'admininfo', 'edit'); ?>" method="post" class="layui-form">
          <input type="hidden" name="user_id" value="<?php echo $details["user_id"] ?>">
          <input type="hidden" name="classe_id" value="<?php echo $classe_id ?>">
          <div class="layui-form-item">
            <label class="layui-form-label">账号：</label>
            <div class="layui-input-inline">
              <input type="text" name="user_num" value="<?php echo $details['user_name']?>" lay-verify="name" autocomplete="off" placeholder="请输入" class="layui-input"  style="width:200px;height:38px;" readonly>
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">姓名：</label>
            <div class="layui-input-inline">
              <input type="text" name="real_name" value="<?php echo $details['real_name'] ?>" lay-verify="name" autocomplete="off" placeholder="请输入" class="layui-input"  style="width:200px;height:38px;">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">手机：</label>
            <div class="layui-input-inline">
              <input type="text" name="phone" value="<?php echo $details['phone'] ?>" lay-verify="name" autocomplete="off" placeholder="请输入" class="layui-input"  style="width:200px;height:38px;">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">QQ：</label>
            <div class="layui-input-inline">
              <input type="text" name="qq" value="<?php echo $details['qq'] ?>" lay-verify="name" autocomplete="off" placeholder="请输入" class="layui-input"  style="width:200px;height:38px;">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">微信：</label>
            <div class="layui-input-inline">
              <input type="text" name="wechat" value="<?php echo $details['wechat'] ?>" lay-verify="name" autocomplete="off" placeholder="请输入" class="layui-input"  style="width:200px;height:38px;">
            </div>
          </div>
          <!-- <div class="layui-form-item">
            <label class="layui-form-label">地址：</label>
            <div class="layui-input-inline">
              <input type="text" name="addr" value="<?php echo $details['addr'] ?>" lay-verify="name" autocomplete="off" placeholder="请输入" class="layui-input"  style="width:200px;height:38px;">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">身份证号：</label>
            <div class="layui-input-inline">
              <input type="text" name="card_id" value="<?php echo $details['card_id'] ?>" lay-verify="name" autocomplete="off" placeholder="请输入" class="layui-input"  style="width:200px;height:38px;">
            </div>
          </div> -->
          <!-- <div class="layui-form-item">
            <label class="layui-form-label">图片</label>
            <div class="layui-upload">
              <button type="button" class="layui-btn" id="test-upload-normal">上传图片</button>
              <div class="layui-upload-list">
                <img class="layui-upload-img filej1" src="<?php echo $details['photo'] ?>" id="test-upload-normal-img" style="height:100px;margin-left:110px;<?php echo $details['photo'] ? 'display:block;' : 'display:none;'; ?>">
                <p id="test-upload-demoText"></p>
                <input type="hidden" name="photo" value="<?php echo $details['photo'] ?>" class="image">
              </div>
            </div>
          </div> -->
          <div class="layui-form-item">
           
            <div class="layui-input-inline" style="margin-left:10%;">
              <button class="layui-btn" lay-submit lay-filter="component-form-element">立即提交</button>
            </div>
          </div>
          <div style="height:20px;"></div>
        </form>
      </div>
    </div>

    <script src="./attms/ms/layuiadmin/layui/layui.js"></script>  
    <script src="./attms/ms/js/jquery.min.js"></script>  
    <script src="./attms/ms/js/init.js"></script>
    <script>
                $('.checkone').change(function () {
                  var type = $(this).is(':checked');
                  var id = $(this).val();
                  $('.check' + id).prop("checked", type);
                })

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

                  //普通图片上传
                  var uploadInst = upload.render({
                    elem: '#test-upload-normal'
                    , url: ImgApi
                    , before: function (obj) {
                      console.log(obj);
                      //预读本地文件示例，不支持ie8
                      obj.preview(function (index, file, result) {
                        layer.msg('图片上传中···');
                      });
                    }
                    , done: function (res) {
                      //如果上传失败
                      if (res.errorCode == '200') {
                        layer.msg('上传成功');
                        $('.filej1').show();
                        $('#test-upload-normal-img').attr('src', res.data); //图片链接（base64）
                        $('.image').val(res.data);
                      } else {
                        return layer.msg('上传失败');
                      }

                    }
                    , error: function () {
                      //演示失败状态，并实现重传
                      var demoText = $('#test-upload-demoText');
                      demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini demo-reload">重试</a>');
                      demoText.find('.demo-reload').on('click', function () {
                        uploadInst.upload();
                      });
                    }
                  });

                  upload.render({
                    elem: '#test-upload-type3'
                    , url: VideoApi
                    , accept: 'video' //视频
                    , done: function (res) {
                      if (res.errorCode == '200') {
                        layer.msg('视频上传成功');
                        var hml = '<video style="width:120px;height:80px;margin-left:11%;" controls ><source src="' + res.data + '" class="file_video" type="video/mp4"></video>'
                        $('.file_video').html(hml);
                        $('.video').val(res.data);
                      } else {
                        return layer.msg('上传失败');
                      }
                    }
                  });

                  form.render(null, 'component-form-group');

                  laydate.render({
                    elem: '#LAY-component-form-group-date'
                  });
                  /* 自定义验证规则 */
                  form.verify({
                    title: function (value) {
                      if (value.length < 1) {
                        return '标题至少得1个字符啊';
                      }
                    }
                    , pass: [/(.+){6,12}$/, '密码必须6到12位']
                    , content: function (value) {
                      layedit.sync(editIndex);
                    }
                  });
                  /* 监听提交 */
                  form.on('submit(component-form-demo1)', function (data) {
//          console.log(JSON.stringify(data.field), {
//            title: '最终的提交信息'
//          })
//
//            console.log(data.field.title);
//            console.log(data.field.image);
//            console.log(data.field.video);
                    console.log(data.field.is_show);
                    $.post('index.php', {c: 'banner', a: 'add', id: data.field.id, title: data.field.title, type: data.field.type, image: data.field.image, sore: data.field.sore, link: data.field.link, is_show: data.field.is_show}, function (response) {
                      var responseObj = $.parseJSON(response);
                      if (responseObj.errorCode == 200) {
                        window.location.href = './index.php?c=banner&a=index';
                      } else {
                        layer.msg(responseObj.description);
                      }
                    });

                    return false;
                  });
                });
    </script>
  </body>
</html>


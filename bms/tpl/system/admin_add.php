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

    </style>
  </head>
  <body>

    <div class="layui-fluid">
      <div class="layui-card">
        <div class="layui-card-header">管理员 添加/编辑</div>
        <div class="layui-card-body" style="padding: 15px;">
          <form class="layui-form"  lay-filter="component-form-group">
            <input type="hidden" name="admin_id" value="<?php echo $detail['admin_id'] ?>">
            <!-- <div class="layui-form-item">
              <label class="layui-form-label">所属部门：</label>
              <div class="layui-input-inline">
                <select name="department_id" lay-filter="department_id" >
                  <option value="0">请选择</option>
                  <?php foreach ($cate as $key => $vo) {?>
                   <?php if($vo['num']==1){?>
                        <option value="<?=$vo['id']?>" <?php if ($detail["department_id"] == $vo['id']) {echo 'selected';} ?>> <?=$vo['title']?></option>
                    <?php }else{?>
                        <option value="<?=$vo['id']?>" <?php if ($detail["department_id"] == $vo['id']) {echo 'selected';} ?>> <?php for($i=1;$i<$vo['num'];$i++){ echo "&nbsp;&nbsp;&nbsp;&nbsp;"; } ?><?=$vo['title']?></option>
                    
                  <?php }}?>
                </select>
              </div>
            </div> -->
            <div class="layui-form-item">
              <label class="layui-form-label">管理员账号</label>
              <div class="layui-input-inline">
                <input type="text" name="user_name" value="<?php echo $detail['user_name'] ?>" lay-verify="user_name" autocomplete="off" placeholder="请输入" class="layui-input">
              </div>
            </div>
            <div class="layui-form-item">
              <label class="layui-form-label">管理员名称</label>
              <div class="layui-input-inline">
                <input type="text" name="real_name" value="<?php echo $detail['real_name'] ?>" lay-verify="real_name" autocomplete="off" placeholder="请输入" class="layui-input">
              </div>
            </div>
            <div class="layui-form-item">
              <label class="layui-form-label">登陆密码</label>
              <div class="layui-input-inline">
                <input type="password" name="password" value="<?php echo $detail['password'] ?>" lay-verify="pass" autocomplete="off" placeholder="请输入" class="layui-input">
              </div>
              <div class="layui-form-mid layui-word-aux">请填写6到12位密码</div>
            </div>
            <div class="layui-form-item">
              <label class="layui-form-label">权限组</label>
              <div class="layui-input-inline">
                <select name="gid" lay-filter="aihao">
                  <?php if (!$detail['gid']) { ?>
                    <option value="" >--请选择管理员权限--</option>
                  <?php } ?>
                  <?php foreach ($res as $ke => $vo) { ?>
                    <option value="<?php echo $vo['id'] ?>" <?php if ($detail['gid'] == $vo['id']) echo 'selected' ?>><?php echo $vo['title'] ?></option>
                  <?php } ?>

                </select>
              </div>
            </div>
            <div class="layui-form-item">
              <label class="layui-form-label">状态</label>
              <div class="layui-input-inline">
                <input type="radio" name="is_del" value="0" title="正常" <?php if ($detail['is_del'] == 0) echo 'checked'; ?>>
                <input type="radio" name="is_del" value="1" title="禁止" <?php if ($detail['is_del'] == 1) echo 'checked'; ?>>
              </div>
            </div>
            <div class="layui-form-item">
              <label class="layui-form-label"></label>
              <div class="layui-input-inline">
                <button class="layui-btn" lay-submit="" lay-filter="component-form-demo1">立即提交</button>
                  <a href="<?php echo pfUrl('', 'system', 'admin_index') ?>" type="reset" class="layui-btn layui-btn-primary">返回</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!--提示框-->
    <div class="video_show" style="position: absolute;z-index:999999;left:50%;top:40%;width:200px;height:50px;background:#8B8989;border-radius: 50px;display:none;">
      <div style="font-size:18px;text-align: center;margin-top:6%;color:#fff;">
        视频上传中···
      </div>
    </div>
    <script src="./attms/ms/layuiadmin/layui/layui.js"></script>  
    <script src="./attms/ms/js/jquery.min.js"></script>  
    <script src="./attms/ms/js/init.js"></script>
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

        //普通图片上传
        var uploadInst = upload.render({
          elem: '#test-upload-normal'
          , url: ImgApi
          , before: function (obj) {
            console.log(obj);
            //预读本地文件示例，不支持ie8
            obj.preview(function (index, file, result) {
              $('.filej1').show();
              $('#test-upload-normal-img').attr('src', result); //图片链接（base64）
            });
          }
          , done: function (res) {
            //如果上传失败
            if (res.errorCode == '200') {
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
            if (value.length < 5) {
              return '标题至少得5个字符啊';
            }
          }
          , pass: [/(.+){6,12}$/, '密码必须6到12位']
          , content: function (value) {
            layedit.sync(editIndex);
          }
        });
        /* 监听提交 */
        form.on('submit(component-form-demo1)', function (data) {
          console.log(JSON.stringify(data.field), {
            title: '最终的提交信息'
          })
  //            
  //            console.log(data.field.title);
  //            console.log(data.field.password);
  //            console.log(data.field.gid);
  //            console.log(data.field.status);
          $.post('index.php', {c: 'system', a: 'admin_add', admin_id: data.field.admin_id,user_name: data.field.user_name, real_name: data.field.real_name, password: data.field.password, gid: data.field.gid, is_del: data.field.is_del}, function (response) {
            var responseObj = $.parseJSON(response);
            if (responseObj.errorCode == 200) {
              window.location.href = './index.php?c=system&a=admin_index';
            } else {
              layer.msg(responseObj.description);
            }
          });

          return false;
        });
      });

      // 照片上传
  //  function previewFile1() {
  //    var file = document.querySelector('#test-upload-primary').files[0];
  //    var reader = new FileReader();
  //    reader.addEventListener("load", function () {
  //      $.ajax({
  //        type: 'POST',
  //        url: './index.php?c=upfile&a=img',
  //        dataType: 'json',
  //        data: {"img": encodeURIComponent(reader.result)},
  //        success: function (responsex)
  //        {
  //          $('.filej1').attr('src', responsex.data);
  //          $('#file1').val(responsex.data);
  //        },
  //        error: function (data)
  //        {
  //          layer.msg(data.description);
  //        }
  //      });
  //    }, false);
  //    if (file) {
  //      reader.readAsDataURL(file);
  //    }
  //  }

      // 文件上传
      function previewFile2() {
        var form = document.getElementById('upload'),
                formData = new FormData(form);
        $('.video_show').show();
        $.ajax({
          type: 'POST',
          url: RestApi + '?c=upfile&a=file_video',
          dataType: 'json',
          data: formData,
          processData: false,
          contentType: false,
          success: function (responsex)
          {

            console.log(responsex);
            if (responsex.errorCode == 200) {
              // alert(responsex.data);
              layer.msg('视频已上传');
              $('.video_show').hide();
              $('.file_video').html('');
              var hml = '视频预览:<video width="150" height="120" controls ><source src="' + responsex.data + '" class="file_video" type="video/mp4"></video>'
              $('.file_video').html(hml);
              $('.name_video').val(responsex.data);
            } else {
              $('.video_show').hide();
              layer.msg(responsex.description);
            }
          },
          error: function (data)
          {
            $('.video_show').hide();
            layer.msg(data.description);
          }
        });
      }


    </script>
  </body>
</html>


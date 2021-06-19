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
        height:30px;
        line-height:30px;
        /*text-align:center;*/
      }
      #div1{text-align:left;width: 700px;height: 30px;}
      .div2{display: inline-block;padding-left: 3px;padding-right:17px;margin-left: 3px;margin-right:17px;}

    </style>
  </head>
  <body>

    <div class="layui-fluid">   
      <div class="layui-card">
        <div style="height:20px;"></div>
        <form action="###" method="post" class="layui-form">
          <input type="hidden" name="id" value="<?php echo $details["id"]; ?>">
          <input type="hidden" name="page" value="<?php echo $page; ?>">
          <div class="layui-form-item">
            <label class="layui-form-label">产品名称：</label>
            <div class="layui-input-inline">
              <input type="text" name="name" value="<?php echo $details["name"] ?>" lay-verify="name" autocomplete="off" placeholder="请输入" class="layui-input">
            </div>
          </div>
         
          <div class="layui-form-item">
            <label class="layui-form-label">产品类别：</label>
            <div class="layui-input-inline">
              <select name="cate_id" lay-filter="is_connect">
                  <option value="">请选择</option>
                <?php foreach ($cate as $k => $v) {?>
                <option value="<?=$v['id']?>" <?php echo $details["cate_id"] == $v['id'] ? 'selected' : '' ?>><?=$v['cate_title']?></option>
                <?php }?>
              </select>
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">通信类型：</label>
            <div class="layui-input-inline">
              <select name="iottype" lay-filter="iottype">
                <option value="0">请选择</option>
                <option value="1" <?php echo $details["iottype"] == 1 ? 'selected' : '' ?>>RS485</option>
                <option value="2" <?php echo $details["iottype"] == 2 ? 'selected' : '' ?>>Zigbee</option>
                <option value="3" <?php echo $details["iottype"] == 3 ? 'selected' : '' ?>>Lora</option>
                <option value="4" <?php echo $details["iottype"] == 4 ? 'selected' : '' ?>>Wifi</option>
                <option value="5" <?php echo $details["iottype"] == 5 ? 'selected' : '' ?>>4G</option>
              </select>
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">驱动类型：</label>
            <div class="layui-input-inline">
              <select name="drive_id" lay-filter="drive_id">
                  <option value="">请选择</option>
                <?php foreach ($drive as $k => $v) {?>
                <option value="<?=$v['drive_id']?>" <?php echo $details["thingtype"] == $v['drive_id'] ? 'selected' : '' ?>><?=$v['drive_name']?></option>
                <?php }?>
              </select>
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">传输协议：</label>
            <div class="layui-input-inline">
              <select name="protocol_id" lay-filter="protocol_id">
                  <option value="">请选择</option>
                <?php foreach ($protocol as $k => $v) {?>
                <option value="<?=$v['protocol_id']?>" <?php echo $details["protocol_id"] == $v['protocol_id'] ? 'selected' : '' ?>><?=$v['protocol_name']?></option>
                <?php }?>
              </select>
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">设备类型</label>
            <div class="layui-input-inline">
               <input type="radio" name="is_connect" value="2" title="网关子设备" <?php $details['is_connect']?$is_connect=$details['is_connect']:$is_connect=2; if($is_connect==2) echo 'checked';?>>
               <input type="radio" name="is_connect" value="1" title="直连设备" <?php if($details['is_connect']==1) echo 'checked';?>>
            </div>
          </div>
          
          <div class="layui-form-item">
            <label class="layui-form-label">产品缩略图</label>
             <div class="layui-upload">
              <button type="button" class="layui-btn" id="test-upload-normal">上传图片</button>
              <div class="layui-upload-list">
                <img class="layui-upload-img filej1" src="<?php echo $details['image']?>" id="test-upload-normal-img" style="height:75px;margin-left:14%;<?php echo $details['image']?'display:block;':'display:none;';?>">
                <p id="test-upload-demoText"></p>
                <input type="hidden" name="image" value="<?php echo $details['image']?>" class="image">
              </div>
            </div>
          </div>


          <div class="layui-form-item">
            <label class="layui-form-label">描述：</label>
            <div class="layui-input-inline">
               <textarea name="remark" placeholder="请输入" class="layui-textarea"><?php echo $details['remark']?></textarea>
            </div>
          </div>
          
          <div class="layui-form-item">
            <label class="layui-form-label"></label>
            <div class="layui-input-inline">
              <button class="layui-btn" lay-submit lay-filter="component-form-element">立即提交</button>
              <button type="reset" class="layui-btn layui-btn-primary" onclick="window.history.back();">返回</button>
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
                  form.on('submit(component-form-element)',function (data){
                        console.log(data);
                        $.post('index.php', {c: 'product', a: 'edit', page:data.field.page,id:data.field.id,name:data.field.name,cate_id:data.field.cate_id,iottype:data.field.iottype,drive_id:data.field.drive_id,protocol_id: data.field.protocol_id,image:data.field.image,is_connect:data.field.is_connect,remark:data.field.remark}, function (response) {
                          var responseObj = $.parseJSON(response);
                          if (responseObj.errorCode == 200) {
                            window.history.back();
                          } else {
                            layer.msg(responseObj.description);
                          }
                        });

                        return false;
                   });
                  
                    //普通图片上传
                  // var uploadInst = upload.render({
                  //   elem: '#test-upload-normal'
                  //   ,url: ImgApi
                  //   ,before: function(obj){
                  //       console.log(obj);
                  //     //预读本地文件示例，不支持ie8
                  //     obj.preview(function(index, file, result){
                  //       layer.msg('图片上传中···');
                  //     });
                  //   }
                  //   ,done: function(res){
                  //     //如果上传失败
                  //     if(res.errorCode=='200'){
                  //       layer.msg('上传成功');
                  //       $('.filej1').show();
                  //       $('#test-upload-normal-img').attr('src', res.data); //图片链接（base64）
                  //         $('.image').val(res.data);
                  //     }else{
                  //         return layer.msg('上传失败');
                  //     }

                  //   }
                  //   ,error: function(){
                  //     //演示失败状态，并实现重传
                  //     var demoText = $('#test-upload-demoText');
                  //     demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini demo-reload">重试</a>');
                  //     demoText.find('.demo-reload').on('click', function(){
                  //       uploadInst.upload();
                  //     });
                  //   }
                  // });

                  $("#test-upload-normal").on('click',function(){
                      var terminal_name=$(this).attr('data-name');
                      var id=$(this).attr('data-id');
                      var product_id=$(this).attr('data-product_id');
                      layer.open({
                           type: 2
                          ,title: '产品图标'
                          ,content: './index.php?c=product&a=lists'
                          ,maxmin: true
                          ,area: ['1000px', '550px']
                          ,btn: ['确定', '取消']
                          ,yes: function(index, layero){
                              var icon_img=localStorage.getItem("icon_img");
                              $('.filej1').show();
                              $('#test-upload-normal-img').attr('src', icon_img); //图片链接（base64）
                              $('.image').val(icon_img);
                            layer.closeAll();
                          }
                      });
                  });
                })
    </script>
  </body>
</html>


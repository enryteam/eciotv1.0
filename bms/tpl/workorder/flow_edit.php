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
          <input type="hidden" name="id" value="<?php echo $details["id"] ?>">
       
          <div class="layui-form-item">
            <label class="layui-form-label">成员名称：</label>
            <div class="layui-input-inline">
              <select name="user_id" lay-filter="aihao">
                <option value="" >请选择...</option>
                <?php foreach($user as $ke=>$vo){?>
                <option value="<?php echo $vo['id']?>" <?php echo $details["user_id"] ==$vo['id'] ? 'selected' : '' ?>><?php echo $vo['user_name']?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">责任说明：</label>
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
                  form.on('submit(component-form-element)', function (data) {
                      console.log(data.field.is_show);
                      $.post('index.php',{c:'workorder',a:'flow_edit',id:data.field.id,user_id:data.field.user_id,remark:data.field.remark}, function(response) {
                          var responseObj=$.parseJSON(response);
                          if(responseObj.errorCode == 200){
                            window.history.back();
                          }else{
                            layer.msg(responseObj.description);
                          }
                      });
                      return false;
                    });
                });
    </script>
  </body>
</html>


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
        <form action="<?php echo pfurl('', 'building', 'edit'); ?>" method="post" class="layui-form">
          <input type="hidden" name="id" value="<?php echo $detail["id"] ?>">
          <div class="layui-form-item">
            <label class="layui-form-label">区域名称：</label>
            <div class="layui-input-inline">
              <input type="text" name="name" value="<?php echo $detail["name"] ?>" placeholder="请输入" class="layui-input">
            </div>
          </div>
          <div class="layui-form-item">
              <label class="layui-form-label">所属区域：</label>
              <div class="layui-input-inline">
                <select name="fid" lay-filter="fid" >
                  <option value="0">请选择</option>
                  <?php foreach ($cate as $key => $vo) {?>
                   <?php if($vo['num']==1){?>
                        <option value="<?=$vo['id']?>" <?php if ($detail["fid"] == $vo['id']) {echo 'selected';} ?>> <?=$vo['name']?></option>
                    <?php }else{?>
                        <option value="<?=$vo['id']?>" <?php if ($detail["fid"] == $vo['id']) {echo 'selected';} ?>> <?php for($i=1;$i<$vo['num'];$i++){ echo "&nbsp;&nbsp;&nbsp;&nbsp;"; } ?><?=$vo['name']?></option>
                    
                  <?php }}?>
                </select>
              </div>
            </div>
          <div class="layui-form-item">
            <label class="layui-form-label">区域面积：</label>
            <div class="layui-input-inline">
              <input type="text" name="area" value="<?php echo $detail["area1"] ?>" placeholder="请输入" class="layui-input">
            </div>
          </div>
         
          <div class="layui-form-item">
            <label class="layui-form-label">备注：</label>
            <div class="layui-input-inline">
              <input type="text" name="describe" value="<?php echo $detail["describe"] ?>" placeholder="请输入" class="layui-input" >
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label"></label>
            <div class="layui-input-inline">
              <button class="layui-btn" lay-submit="" lay-filter="component-form-demo1">立即提交</button>
              <button type="reset" class="layui-btn layui-btn-primary" onclick="javascript:window.history.go(-1);">返回</button>
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
      layui.config({
        base: './attms/ms/layuiadmin/' //静态资源所在路径
      }).extend({
        index: 'lib/index' //主入口模块
      }).use(['index', 'laydate', 'form', 'upload'], function () {

        var laydate = layui.laydate;
        var upload = layui.upload;
        var form = layui.form;
        
        form.on('select(fid)',function (data){
            console.log(data);
            if(data.value>0){
                $('.type_delete').hide();
            }else{
                $('.type_delete').show();
            }
        });
       
        /* 监听提交 */
        form.on('submit(component-form-demo1)', function (data) {
            console.log(data);
          $.post('index.php', {c: 'building', a: 'edit', id: data.field.id, name: data.field.name,gateway_id:data.field.gateway_id,fid:data.field.fid, type_id: data.field.type_id, area: data.field.area, describe: data.field.describe}, function (response) {
            var responseObj = $.parseJSON(response);
            if (responseObj.errorCode == 200) {
              window.history.back();
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


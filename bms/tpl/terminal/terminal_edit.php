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
            <label class="layui-form-label">所属产品：</label>
            <div class="layui-input-inline">
              <select name="product_id" lay-filter="product_id">
                <?php foreach ($type as $k => $v) {?>
                <option value="<?=$v['id']?>" <?php echo $details["product_id"] == $v['id'] ? 'selected' : '' ?>><?=$v['name']?></option>
                <?php }?>
              </select>
            </div>
          </div>

		  <div class="layui-form-item">
            <label class="layui-form-label">所属网关：</label>
            <div class="layui-input-inline">
              <select name="gateway_id" lay-filter="gateway_id">
                  <option value="0">请选择</option>
                <?php foreach ($gateway as $k => $v) {?>
                <option value="<?=$v['id']?>" <?php echo $details["gateway_id"] == $v['id'] ? 'selected' : '' ?>><?=$v['sn']?></option>
                <?php }?>
              </select>
            </div>
          </div>

		

			<div class="layui-form-item">
				<label class="layui-form-label">安装位置：</label>
				<div class="layui-input-inline">
				  <input type="text" name="addr" value="<?php echo $details["addr"] ?>" lay-verify="addr" autocomplete="off" placeholder="请输入" class="layui-input">
				</div>
			  </div>
          

          <div class="layui-form-item">
            <label class="layui-form-label">设备SN：</label>
            <div class="layui-input-inline">
              <input type="text" name="sn" value="<?php echo $details["sn"]?$details["sn"]:$sn ?>" lay-verify="sn" autocomplete="off" placeholder="请输入" class="layui-input">
            </div>
          </div>

          <div class="layui-form-item">
            <label class="layui-form-label">设备名称：</label>
            <div class="layui-input-inline">
              <input type="text" name="name" value="<?php echo $details["name"] ?>" lay-verify="name" autocomplete="off" placeholder="请输入" class="layui-input">
            </div>
          </div>

          

          <div class="layui-form-item">
            <label class="layui-form-label">通道路线：</label>
            <div class="layui-input-inline">
              <input type="text" name="iotchannel" value="<?php echo $details["iotchannel"] ?>" lay-verify="iotchannel" autocomplete="off" placeholder="请输入" class="layui-input">
            </div>
            <label class="layui-form-label" style="color:red;width:300px;text-align:left;">通信线路 1路线 2 路线 </label>
          </div>

          <div class="layui-form-item">
            <label class="layui-form-label">设备地址：</label>
            <div class="layui-input-inline">
              <input type="text" name="iotaddress" value="<?php echo $details["iotaddress"] ?>" lay-verify="iotaddress" autocomplete="off" placeholder="请输入" class="layui-input">
            </div>
            <!-- <span style="color:red;">设备  485(1-128) IP地址 (用软件或工具修改)</span> -->
            <label class="layui-form-label" style="color:red;width:300px;text-align:left;">设备  485(1-128) IP地址 (用软件或工具修改) </label>
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
                  /* 监听提交 */
                form.on('submit(component-form-element)', function (data) {
                  console.log(data.field.is_show);
                  $.post('index.php',{c:'terminal',a:'terminal_edit',id:data.field.id,building_id:data.field.building_id,gateway_id:data.field.gateway_id,product_id:data.field.product_id,addr:data.field.addr,sn:data.field.sn,name:data.field.name,iotchannel:data.field.iotchannel,iotaddress:data.field.iotaddress,fault:data.field.fault}, function(response) {
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


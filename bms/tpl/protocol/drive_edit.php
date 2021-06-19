<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?= $_SESSION['logo'] ?></title>
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
      .layui-form-item .layui-input-inline{ width: 300px!important;}
    </style>
  </head>
  <body>

    <div class="layui-fluid">   
      <div class="layui-card">
        <div style="height:20px;"></div>
        <form action="###" method="post" class="layui-form">
          <input type="hidden" name="drive_id" value="<?php echo $details["drive_id"] ?>">

          <div class="layui-form-item">
            <label class="layui-form-label">驱动名称：</label>
            <div class="layui-input-inline">
              <input type="text" name="drive_name" value="<?php echo $details["drive_name"] ?>" lay-verify="drive_name" autocomplete="off" placeholder="请输入" class="layui-input">
            </div>
          </div>
     
          <div class="layui-form-item">
            <label class="layui-form-label">驱动文件：</label>
            <div class="layui-input-inline">
            <select name="drive_script" lay-filter="drive_script">
            <option>请选择</option>
            <?php
              $files = scandir("../protocol/drive/");
              foreach($files as $file){
                if(strpos("#".$file,"thingtype_"))
                {?>
                <option value="<?php echo $file;?>" <?php echo $details["drive_script"] == $file ? 'selected' : '' ?>>../protocol/drive/<?php echo $file;?></option>
            <?php }
              }
            ?>
              </select>            
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">驱动说明：</label>
            <div class="layui-input-inline">
              <input type="text" name="drive_remark" value="<?php echo $details["drive_remark"]?$details["drive_remark"]:'官方驱动' ?>" lay-verify="drive_remark" autocomplete="off" placeholder="请输入" class="layui-input">
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
                   form.on('submit(component-form-element)',function (data){
                        console.log(data);
                        $.post('index.php', {c: 'protocol', a: 'drive_edit', drive_id: data.field.drive_id, drive_name: data.field.drive_name,drive_script:data.field.drive_script,drive_remark:data.field.drive_remark}, function (response) {
                          var responseObj = $.parseJSON(response);
                          
                          if (responseObj.errorCode == 200) {
                            window.history.back();
                          } else {
                            layer.msg(responseObj.description);
                          }
                        });

                        return false;
                   });
                  
                  
                  
                  
                  
                  
                  form.on('select(building)', function (data) {
                    $.post('index.php', {c: 'terminal', a: 'floor', building_id: data.value}, function (response) {
                      var responseObj = $.parseJSON(response);
                      if (responseObj.errorCode == 200) {
                        console.log()
                        var tag2List = responseObj.data.floors;
                        var options = "<option value=''>请选择</option>";
                        for (var i = 0; i < tag2List.length; i++) {
                          var tag = tag2List[i];
                          options += ' <option value="' + tag.id + '">' + tag.name + '</option>';
                        }
                        $("select[name='floor_id']").html(options)
                        var tag3List = responseObj.data.rooms;
                        var options3 = "<option value=''>请选择</option>";
                        for (var i = 0; i < tag3List.length; i++) {
                          var tag = tag3List[i];
                          options3 += ' <option value="' + tag.id + '">' + tag.name + '</option>';
                        }
                        $("select[name='room_id']").html(options3)
                        //初始化子分类
                        //参数1 type  参数2 filter
                        form.render('select');
                      } else {
                        layer.msg(responseObj.description);
                      }
                    });
                  })

                  form.on('select(floor)', function (data) {
                    $.post('index.php', {c: 'terminal', a: 'room', floor_id: data.value}, function (response) {
                      var responseObj = $.parseJSON(response);
                      if (responseObj.errorCode == 200) {
                        var tag3List = responseObj.data;
                        var options3 = "<option value=''>请选择</option>";
                        for (var i = 0; i < tag3List.length; i++) {
                          var tag = tag3List[i];
                          options3 += ' <option value="' + tag.id + '">' + tag.name + '</option>';
                        }
                        $("select[name='room_id']").html(options3)
                        //初始化子分类
                        //参数1 type  参数2 filter
                        form.render('select');
                      } else {
                        layer.msg(responseObj.description);
                      }
                    });
                  })
                })
    </script>
  </body>
</html>


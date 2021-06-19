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
        .layui-form-label {
            float: left;
            display: block;
            padding: 9px 5px;
            width: 70px;
            font-weight: 400;
            line-height: 20px;
            text-align: center; 
        }
    </style>
    <style type="text/css">
*{margin: 0; padding: 0;}
#mian{ width:940px; height:400px;}
#leftBox{background:#ecf0f5;width:35px; height:400px; text-align:left; float: left;}
#test{border:1px solid #eaeaea; outline:none; width:900px; height:400px; resize: none; background: rgb(250,250,250); line-height: 24px;font-size: 14px;float: left; padding:10px 8px;  color: black; font-family: inherit; box-sizing: border-box;}
#leftNum{ height:100%; width: 100%; resize: none;outline:none; overflow-y: hidden; overflow-x: hidden; border: 0; background: rgb(247,247,247); color: #999;line-height: 24px;font-size: 14px; padding:10px 4px; text-align: right; font-weight: bold; box-sizing: border-box;}
</style>
  </head>
  <body>

    <div class="layui-fluid">   
      <div class="layui-card">
        <div style="height:20px;"></div>
        
       <form action='#' method='post' class='layui-form'>
          <input type="hidden" name="product_id" value="<?php echo $product_id ?>">
          <div style="height:20px;margin-left:20px;text-align:left;"><?php echo $r['name'].'的功能脚本'?></div>
          <div style="height:20px;margin-left:20px;text-align:left;">
            
          当前文件： ../protocol/scripts/eciot_product_<?php echo $product_id ?>.php
          </div>
         
          <div class="layui-form-item">
            <!--<label class="layui-form-label">产品名称：</label>-->
            <div class="layui-input-inline">
             <div id="mian">
                <div id="leftBox"><textarea wrap="off" cols="2" id="leftNum" disabled></textarea></div>
                <textarea id="test" name="copy" onkeydown="keyUp()" onscroll="getId('leftNum').scrollTop = this.scrollTop;"><?php echo $editfile ?></textarea>
            </div>
            </div>
          </div>
          
          <div class="layui-form-item">
            <label class="layui-form-label"></label>
            <div class="layui-input-inline">
              <button class="layui-btn" lay-submit lay-filter="component-form-element">确认保存</button>
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
                 
                  
                  
                  
                })
    </script>
    <script type="text/javascript">
var num = "";
var btn = getId('btn');
var test = getId('test');
function getId(obj) {
    return document.getElementById(obj);
}
function keyUp(){
    var str = test.value;
    str = str.replace(/\r/gi,"");
    str = str.split("\n");
    n = str.length;
    line(n);
}
function line(n){
    var lineobj = getId("leftNum");
    for(var i = 1;i <= n;i ++){
       if(document.all){
        num += i + "\r\n";//判断浏览器是否是IE
       }else{
        num += i + "\n";
       }
    }
    lineobj.value = num;
    num = "";
}

(function() {
    keyUp();
})();
</script>
  </body>
</html>


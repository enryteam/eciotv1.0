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
</head>
<body>

  <div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md12">
        <div class="layui-card">
          <div class="layui-card-header">修改密码</div>
          <div class="layui-card-body" pad15>
            
            <div class="layui-form" lay-filter="">
              <div class="layui-form-item">
                <label class="layui-form-label">当前密码</label>
                <div class="layui-input-inline">
                  <input type="password" name="oldPassword" lay-verify="required" lay-verType="tips" class="layui-input password">
                </div>
              </div>
              <div class="layui-form-item">
                <label class="layui-form-label">新密码</label>
                <div class="layui-input-inline">
                  <input type="password" name="password" lay-verify="pass" lay-verType="tips" autocomplete="off" id="LAY_password" class="layui-input pwd">
                </div>
                <div class="layui-form-mid layui-word-aux">6到16个字符</div>
              </div>
              <div class="layui-form-item">
                <label class="layui-form-label">确认新密码</label>
                <div class="layui-input-inline">
                  <input type="password" name="repassword" lay-verify="repass" lay-verType="tips" autocomplete="off" class="layui-input repwd">
                </div>
              </div>
              <div class="layui-form-item">
                <div class="layui-input-block">
                  <button class="layui-btn" lay-submit lay-filter="setmypass">确认修改</button>
                </div>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </div>

 <script src="./attms/ms/layuiadmin/layui/layui.js"></script>
  <script>
  layui.config({
    base: './attms/ms/layuiadmin/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index','jquery','set'], function(){
    var $ = layui.$,form = layui.form;//内部使用jquery
	form.render();
    //验证码
    var sliderVerify = layui.sliderVerify,
      form = layui.form;
   
   // if(slider.isOk()){
	//	$('#LAY-user-login-username').val('324324');
	//}
    
	//监听提交
	form.on('submit(setmypass)', function(obj){
		var password=$('.password').val();
		var pwd=$('.pwd').val();
		var repwd=$('.repwd').val();
		if(!password){
                    layer.msg('请输入原密码');
                    return true;
                }
                if(!pwd){
                    layer.msg('请输入新密码');
                    return true;
                }
                if(pwd!=repwd){
                    layer.msg('两次密码不一致');
                    return true;
                }
                $.post('index.php',{c:'index',a:'password',pwd:pwd,repwd:repwd,password:password}, function(response) {
                        var responseObj=$.parseJSON(response);
                        if(responseObj.errorCode == 200){
//                                window.location.href='./index.php?c=index&a=login';
                                parent.location.href="./index.php?c=index&a=login"
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
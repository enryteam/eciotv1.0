<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<link rel="stylesheet" type="text/css" href="./attms/ms/css/index.css"/>
		<link rel="stylesheet" type="text/css" href="./attms/ms/css/common.css"/>
		<title>物联网基础平台</title>
		<style>
			.code
			{
				font-family:Arial;
				font-style:italic;
				color:blue;
				font-size:30px;
				border:0;
				padding:2px 3px;
				letter-spacing:3px;
				font-weight:bolder;            
				float:left;           
				cursor:pointer;
				width:150px;
				height:57px;
				line-height:60px;
				text-align:center;
				vertical-align:middle;
				background-color:#D8B7E3;
				position: absolute;
				font-size: 18px;
				margin-top: -10px;
				margin-left: 148px;
			}
			.code-span {
				text-decoration:none;
				font-size:12px;
				color:#288bc4;
				padding-left:10px;
				position: absolute;
				z-index:1px;
				margin-top:30px;
				margin-left:-22px;
			}

			.code-span:hover {
				text-decoration:underline;
				cursor:pointer;
			}
		</style>
                <script>
				if(window != top){  
					top.location.href=location.href;  
				};
		</script>
	</head>
	<body>
		<div class="main">
			<div class="mc">
				<div class="ahead">
					<a target="_blank" href="https://www.51daniu.cn/" rel="noopener noreferrer" >
						<img style="width:150px" src="https://eciot.oss-cn-shanghai.aliyuncs.com/portal/img/logo.png" >
					</a>
          <img class="slogan" src="./attms/ms/img/slogon.png" >
				</div>
				<div class="aside">
					<img src="./attms/ms/img/side.png" >
				</div>
				<div class="form">
					<div class="fc">
						<div class="logimg">
							<img src="./attms/ms/img/login.png" >
						</div>
						<div class="account">
							<div class="username">						
							<i></i>
								<input type="text" id="username" placeholder="请输入账号" autocomplete="off" />
							</div>
							<div class="password">
								<i></i>
								<input type="password" id="password" placeholder="请输入密码"  autocomplete="off"  />
								<span id="eye"></span>
							</div>
							<div class="username">
								<input type="text" id="inputCode" placeholder="请输入验证码"/>
								<div id="checkCode" class="code"  onclick="createCode(4)" ></div>
								<span class="code-span"  onclick="createCode(4)">看不清换一张</span>
							</div>
							<button class="loginbtn" type="button">登录</button>
						</div>
						
					</div>
				</div>
				<div class="afoot">
				<p>Copyright  2020-2030 51DANIU.CN Inc. All rights reserved.</p>
				<p>苏 ICP 备15034057号-1</p>
				</div>
			</div>
		</div>
		<script src="./attms/ms/js/jquery.min.js" type="text/javascript"></script>
		<script type="text/javascript">
			var userAgent = navigator.userAgent.toLowerCase();   
			// Figure out what browser is being used
			   jQuery.browser = {
			    version: (userAgent.match(/.+(?:rv|it|ra|ie)[\/: ]([\d.]+)/) || [])[1],
			    safari: /webkit/.test(userAgent),
			    opera: /opera/.test(userAgent),
			    msie: /msie/.test(userAgent) && !/opera/.test(userAgent),
			    mozilla:/mozilla/.test(userAgent)&&!/(compatible|webkit)/.test(userAgent)
			    };
			if($.browser.msie) {
				$("#password").css("width", "250px")
				$("#eye").hide()
			}
			$("#eye").on('click',function(){
				var type =$("#password").attr("type")
				if(type == "password"){
					$("#password").attr("type","text")
				}else{
					$("#password").attr("type","password")
				}
			})
			$('.loginbtn').click(function () {
				var username = $('#username').val();
				var password = $('#password').val();
				
				//获取显示区生成的验证码
				var checkCode = document.getElementById("checkCode").innerHTML;
				//获取输入的验证码
				var inputCode = document.getElementById("inputCode").value;
				if (inputCode.length <= 0)
				{
					alert("请输入验证码！");
					return false;
				}
				else if (inputCode.toUpperCase() != checkCode.toUpperCase())
				{
					alert("验证码输入有误！");
					createCode(4);
					return false;
				}

				$.post('index.php', {c: 'index', a: 'dologin', user_name: username, pass_word: password}, function (response) {
				var responseObj = $.parseJSON(response);
				if (responseObj.errorCode == 200) {
					window.location.href = './index.php?c=index&a=index';
				} else {
					alert(responseObj.description);
				}
				});
			})

			//页面加载时，生成随机验证码
			window.onload=function(){
				createCode(4);    
			}

   		//生成验证码的方法
		function createCode(length) {
			var code = "";
			var codeLength = parseInt(length); //验证码的长度
			var checkCode = document.getElementById("checkCode");
			////所有候选组成验证码的字符，当然也可以用中文的
			var codeChars = new Array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9,
			'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',
			'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'); 
			//循环组成验证码的字符串
			for (var i = 0; i < codeLength; i++)
			{
				//获取随机验证码下标
				var charNum = Math.floor(Math.random() * 62);
				//组合成指定字符验证码
				code += codeChars[charNum];
			}
			if (checkCode)
			{
				//为验证码区域添加样式名
				checkCode.className = "code";
				//将生成验证码赋值到显示区
				checkCode.innerHTML = code;
			}
		}
    
			//检查验证码是否正确
			function validateCode()
			{
				//获取显示区生成的验证码
				var checkCode = document.getElementById("checkCode").innerHTML;
				//获取输入的验证码
				var inputCode = document.getElementById("inputCode").value;
				//console.log(checkCode);
				//console.log(inputCode);
				if (inputCode.length <= 0)
				{
					alert("请输入验证码！");
				}
				else if (inputCode.toUpperCase() != checkCode.toUpperCase())
				{
					alert("验证码输入有误！");
					createCode(4);
				}
				else
				{
					alert("验证码正确！");
				}       
			}
		</script>
	</body>
</html>

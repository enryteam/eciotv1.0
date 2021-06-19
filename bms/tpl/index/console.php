

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title></title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="./attms/ms/layuiadmin/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="./attms/ms/layuiadmin/style/admin.css" media="all">
  <style>
    .layadmin-carousel {
      height: 85px !important;
      background-color: #fff;
  }
    </style>
</head>
<body>

  <div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md12">
        <div class="layui-row layui-col-space15">
          <div class="layui-col-md12">

            <?php foreach ($menu as $value) {?>


            <div class="layui-card">
              <div class="layui-card-header"><?php echo $value['menu']['title']?></div>
              <div class="layui-card-body">

                <div class="layui-carousel layadmin-carousel layadmin-shortcut">
                  <div carousel-item>
                    <ul class="layui-row layui-col-space15">
                      <?php foreach ($value['son'] as $val) {?>
                      <li class="layui-col-xs2">
                        <a lay-href="./index.php?c=<?php echo $val['controller']?>&a=<?php echo $val['action']?>">
                          <i class="layui-icon <?php echo $val['icon_img']?>"></i>
                          <cite><?php echo $val['title']?></cite>
                        </a>
                      </li>
                      <?php }?>

                    </ul>

                  </div>
                </div>

              </div>
            </div>
          <?php }?>
          </div>

        </div>
      </div>


  </div>

  <script src="./attms/ms/layuiadmin/layui/layui.js"></script>
  <script src="./attms/js/jquery.min.js"></script>
  <script>
   layui.config({
            base: './attms/ms/layuiadmin/' //静态资源所在路径
          }).extend({
            index: 'lib/index' //主入口模块
          }).use(['index','laydate' ,'form','upload','console'], function(){

            var laydate = layui.laydate;
            var upload = layui.upload;
            var admin = layui.admin
            var layer = layui.layer;
        countDown();
      });
  </script>
</body>
</html>

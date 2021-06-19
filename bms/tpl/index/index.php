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
  <body class="layui-layout-body">

    <div id="LAY_app">
      <div class="layui-layout layui-layout-admin">
        <div class="layui-header">
          <!-- 头部区域 -->
          <ul class="layui-nav layui-layout-left">
          <li class="layui-nav-item layadmin-flexible" lay-unselect="">
            <a href="javascript:;" layadmin-event="flexible" title="侧边伸缩">
              <i class="layui-icon layui-icon-shrink-right" id="LAY_app_flexible"></i>
            </a>
          </li>
            <li class="layui-nav-item" lay-unselect="">
              <a href="javascript:;" layadmin-event="refresh" title="刷新">
                <i class="layui-icon layui-icon-refresh-3"></i>
              </a>
            </li>
            <span class="layui-nav-bar" style="left: 30px; top: 48px; width: 0px; opacity: 0;"></span></ul>
          <ul class="layui-nav layui-layout-right" lay-filter="layadmin-layout-right">
            <li class="layui-nav-item" lay-unselect>
              <a href="javascript:;">
                <cite><?php echo $_SESSION['real_name'] ?></cite>
              </a>
              <dl class="layui-nav-child">
                <dd><a lay-href="<?php echo pfUrl('', 'admininfo', 'edit') ?>">基础资料</a></dd>

                <dd><a lay-href="<?php echo pfUrl('', 'admininfo', 'change_pwd') ?>">修改密码</a></dd>
                <hr>
                <dd layadmin-event=""  style="text-align: center;" onclick="window.location.href = './index.php?c=index&a=logout'"><a>安全退出</a></dd>
              </dl>
            </li>
          </ul>
        </div>

        <!-- 侧边菜单 -->
        <div class="layui-side layui-side-menu">
          <div class="layui-side-scroll">
            <div class="layui-logo" lay-href="./index.php?c=index&a=console">
              <span>物联网基础平台</span>
            </div>

            <ul class="layui-nav layui-nav-tree" lay-shrink="all" id="LAY-system-side-menu" lay-filter="layadmin-system-side-menu">
              <?php foreach ($re as $ke => $vo) { ?>
                <li data-name="index" class="layui-nav-item <?php if ($ke == 0) echo 'layui-nav-itemed'; ?>">
                  <?php if($ke == 0){?>
                    <a lay-href="<?=pfUrl('', $vo['controller'], 'console')?>" lay-tips="<?php echo $vo['title'] ?>" lay-direction="2">
                  <?php }else if($vo['lists']){?>
                    <a href="javascript:;" lay-tips="<?php echo $vo['title'] ?>" lay-direction="2">
                  <?php }else{?> 
                    <a lay-href="<?php echo $vo['lists'] ? 'javascript:;' : pfUrl('', $vo['controller'], 'index') ?>" lay-tips="<?php echo $vo['title'] ?>" lay-direction="2">
                  <?php }?>
                    <i class="layui-icon <?php echo $vo['action'] ?>"></i>
                    <cite><?php echo $vo['title'] ?></cite>
                  </a>
                  <!--最后添加权限的时候用到的数据--不可删除  and id in($ids1)  -->
                  <?php foreach ($vo['lists'] as $k => $v) { ?>
                    <dl class="layui-nav-child">
                      <dd data-name="console" class="<?php if ($k == 0) echo 'layui-this'; ?>">
                        <a lay-href="./index.php?c=<?php echo $v['controller'] ?>&a=<?php echo $v['action'] ?>"><?php echo $v['title'] ?></a>
                      </dd>
                    </dl>
                  <?php } ?>
                </li>
              <?php } ?>

            </ul>
          </div>
        </div>

        <!-- 页面标签 -->
        <div class="layadmin-pagetabs" id="LAY_app_tabs">
          <div class="layui-icon layadmin-tabs-control layui-icon-prev" layadmin-event="leftPage"></div>
          <div class="layui-icon layadmin-tabs-control layui-icon-next" layadmin-event="rightPage"></div>
          <div class="layui-icon layadmin-tabs-control layui-icon-down">
            <ul class="layui-nav layadmin-tabs-select" lay-filter="layadmin-pagetabs-nav">
              <li class="layui-nav-item" lay-unselect>
                <a href="javascript:;"></a>
                <dl class="layui-nav-child layui-anim-fadein">
                  <dd layadmin-event="closeThisTabs"><a href="javascript:;">关闭当前标签页</a></dd>
                  <dd layadmin-event="closeOtherTabs"><a href="javascript:;">关闭其它标签页</a></dd>
                  <dd layadmin-event="closeAllTabs"><a href="javascript:;">关闭全部标签页</a></dd>
                </dl>
              </li>
            </ul>
          </div>
          <div class="layui-tab" lay-unauto lay-allowClose="true" lay-filter="layadmin-layout-tabs">
            <ul class="layui-tab-title" id="LAY_app_tabsheader">
              <li lay-id="<?php echo pfUrl('', 'index', 'console') ?>" lay-attr="<?php echo pfUrl('', 'index', 'console') ?>" class="layui-this"><i class="layui-icon layui-icon-home"></i></li>
            </ul>
          </div>
        </div>

        <!-- 主体内容 -->
        <div class="layui-body" id="LAY_app_body">
          <div class="layadmin-tabsbody-item layui-show">
            <iframe src="<?php echo pfUrl('', 'index', 'console') ?>" frameborder="0" class="layadmin-iframe"></iframe>
          </div>
        </div>

        <!-- 辅助元素，一般用于移动设备下遮罩 -->
        <div class="layadmin-body-shade" layadmin-event="shade"></div>
      </div>
    </div>

    <script src="./attms/ms/layuiadmin/layui/layui.js"></script>
    <script>
                  layui.config({
                    base: './attms/ms/layuiadmin/' //静态资源所在路径
                  }).extend({
                    index: 'lib/index' //主入口模块
                  }).use('index');


    </script>


  </body>
</html>

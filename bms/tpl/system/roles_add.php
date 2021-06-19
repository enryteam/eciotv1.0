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

      .box_ul, .box_ul li{
        list-style:none; /* 将默认的列表符号去掉 */
        padding:0; /* 将默认的内边距去掉 */
        margin:0; /* 将默认的外边距去掉 */
      }
      .box_ul li{
        float:left; /* 往左浮动 */
        margin-left:10px;
      }
      .lay_box_lable{
        text-decoration: none;
        margin: 0px;
        display: block; /* 作为一个块 */
        height:30px;
        line-height:30px;
        /*text-align:center;*/
      }
      .lay_box_lable1{
        text-decoration: none;
        margin: 0px;
        display: block; /* 作为一个块 */
        width:90px;
        height:30px;
        line-height:30px;
        text-align:left;
      }

      .layui-form-checkbox, .layui-form-checkbox *, .layui-form-switch {
          display: none;
          vertical-align: middle;
      }

    </style>
  </head>
  <body>

    <div class="layui-fluid">   
      <div class="layui-card">
        <div style="height:20px;"></div>
        <form action="<?php echo pfurl('', 'system', 'roles_add'); ?>" method="post" class="form-horizontal">
          <input type="hidden" name="id" value="<?php echo $detail['id'] ?>">

          <div class="layui-form-item">
            <label class="layui-form-label">角色：</label>
            <div class="layui-input-inline">
              <input type="text" name="title" value="<?php echo $detail['title'] ?>" lay-verify="title" autocomplete="off" placeholder="请输入" class="layui-input"  style="width:200px;height:30px;">
            </div>
          </div>  
          <div class="layui-form-item">
            <label class="layui-form-label" style="margin-top:-8px;font-size:17px;font-weight:bold;">状态：</label>
            <div class="layui-input-inline"  >
              <input type="radio" name="status" value="1" title="正常" <?php if ($detail['status'] == 0) echo '';
else echo 'checked' ?> style="margin:0 5px;width:17px;height:17px;vertical-align:middle;margin-top: -1px;">正常
              <input type="radio" name="status" value="0" title="禁止" <?php if ($detail['status'] == 0) echo 'checked';
else echo '' ?> style="margin:0 5px;margin-left:10px;width:17px;height:17px;vertical-align:middle;margin-top: -1px;">禁止
            </div>
          </div>

          <div class="layui-card-body">

<!--        <table id="LAY-user-back-role" lay-filter="LAY-user-back-role"></table>  -->

            <div class="layui-form layui-border-box layui-table-view" lay-filter="LAY-table-4" lay-id="LAY-user-back-role" style=" ">
              <div style="font-size:17px;font-weight:bold;margin-bottom:10px;margin-top:10px;">
              用户权限：<span class="btn-submit" style="width:80px;height:40px;background:#1E9FFF;color:#ffffff;padding:5px 20px;border:1px solid #1E9FFF;border-radius:8px;margin-left:20px; ">更新权限组 </span>
              </div>
              <div class="layui-table-box">
                <div class="layui-table-body">
                  <table cellspacing="0" cellpadding="0" border="0" class="layui-table" style="width:100%">
                    <thead>
                      <tr>
                        <th data-field="limits" data-key="4-0-3" class="" style="width:15%">
                    <div class="layui-table-cell laytable-cell-4-0-3">
                      <span style="font-size:18px;">基础平台</span>
                    </div>
                    </th>
                    <th data-field="descr" data-key="4-0-4" class="" style="width:85%">
                    <div class="layui-table-cell laytable-cell-4-0-4">
                      <span style="font-size:18px;">权限</span>
                    </div>
                    </th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($res as $ke => $vo) { ?>
                        <tr data-index="0" class="">
                          <td data-field="id"  class="">

                            <div class="layui-table-cell " style="height:auto;" >
                              <ul class="box_ul">
                                <li><lable class="lay_box_lable"> <input type="checkbox" name="rules[]" data-id="<?php echo $vo['id']?>" value="<?php echo $vo['module'] ?>" class="fid_<?php echo $vo['id']?> checkone" <?php if (in_array($vo['module'], explode(',', $detail['rules']))) echo'checked' ?> style="display:inline;width:17px;height:17px;margin-top:-3px;vertical-align:middle;"><span style="margin-left:10px;font-size:15px;" ><?php echo $vo['title'] ?></span></lable></li>
                              </ul>
                            </div>
                          </td>
                          <td data-field="rolename"  class="">
                            <div class="layui-table-cell " style="height:auto;" >
                              <ul class="box_ul">
                                <?php foreach ($vo['zi'] as $k => $v) { ?>
                                  <li><lable class="lay_box_lable"><input type="checkbox" name="rules0[]" data-id="<?php echo $v['fid']?>" class="checked_on check<?= $v['fid'] ?>  <?php if (in_array($v['module'], explode(',', $detail['rules']))) echo'one_'.$v['fid']; ?>" value="<?php echo $v['module'] ?>" <?php if (in_array($v['module'], explode(',', $detail['rules']))) echo'checked' ?> style="display:inline;width:17px;height:17px;margin-top:-3px;vertical-align:middle;" ><span style="margin-left:5px;font-size:15px" ><?php echo $v['title'] ?></span></lable></li>
  <?php } ?>
                              </ul>
                            </div>
                          </td>
                        </tr>
<?php } ?>
                    </tbody>
                   
                  </table>
                </div>
              </div>
            </div>

          </div>

          <div class="layui-card-body layui-row layui-col-space10">
            <div class="layui-col-md12">
              <textarea name="remark" placeholder="请输入权限组备注备注" class="layui-textarea"  style="width:20%;"><?php echo $detail['remark'] ?></textarea>
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label"></label>
            <div class="layui-input-inline">
              <button class="layui-btn" lay-submit lay-filter="component-form-element">立即提交</button>
              <button type="reset" class="layui-btn layui-btn-primary" onclick="window.location.href = './index.php?c=system&a=roles_index'">返回</button>
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
        //常规用法
        laydate.render({
          elem: '#test-laydate-normal-cn'
        });
        laydate.render({
          elem: '#test-laydate-normal-cn1'
        });
        

              $('.btn-submit').on('click',function(){
                $.ajax({
                  type: 'POST',
                  url: './index.php?c=system&a=admin_index_rule',
                  dataType: 'json',
                  data: {},
                  success: function (responsex)
                  {
                    layer.msg(responsex.description);
                    setTimeout(() => {
                      window.location.reload();
                    }, 1500);
                  },
                  error: function (data)
                  {
                    layer.msg(data.description);
                  }
                });
              });
      });

          $('.checkone').change(function () {
            var type = $(this).is(':checked');
            var id = $(this).attr('data-id');
            $('.check' + id).prop("checked", type);
            if(type){
                $('.check'+ id).addClass('one_'+id);
            }else{
                 $('.check'+ id).removeClass('one_'+id);
            }
          })

          $('.checked_on').change(function(){
            var fid=$(this).attr('data-id');
            var type = $(this).is(':checked');
            if(type){
                $(this).addClass('one_'+fid);
            }else{
                $(this).removeClass('one_'+fid);
            }
            var len=$('.one_'+fid).length;
            console.log();
            if(len>0){
                $('.fid_' + fid).prop("checked", true);
            }else{
                $('.fid_' + fid).prop("checked", false);
            }
          });

          

    </script>
  </body>
</html>


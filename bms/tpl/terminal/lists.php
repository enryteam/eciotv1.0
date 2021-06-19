<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?=$_SESSION['logo']?></title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="./attms/ms/layuiadmin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="./attms/ms/layuiadmin/style/admin.css" media="all">
    <style>
      .laytable-cell-4-0-0{ width: 48px; }.laytable-cell-4-0-1{ width: 80px; }.laytable-cell-4-0-2{  }.laytable-cell-4-0-3{  }.laytable-cell-4-0-4{  }.laytable-cell-4-0-5{ width: 150px; }
      .layer_box{
        position:absolute;
        background: red;
        width:100px;
        height:100px;
        left:8%;
        z-index:9999999;
      }
      .layui-form-item .layui-input-inline {
          float: left;
          width: 90%;
          margin-right: 10px;
      }

    pre {padding: 5px; margin:30px; }
    .string { color: green; }        /*字符串的样式*/
    .number { color: darkorange; }    /*数字的样式*/
    .boolean { color: blue; }        /*布尔型数据的样式*/
    .null { color: magenta; }        /*null值的样式*/
    .key { color: red; }            /*key值的样式*/
    .layui_back{
        background-color:#ccc;
        color:#000;
    }
    </style>
  </head>
  <body>
    <?php if($event){?>
    <div class="layui-fluid">   
      <div class="layui-card">
        <div class="layui-card-body">
          <div style="padding-bottom: 10px;">
              <form name="searchform" class="layui-form" method="POST">
                <div class="layui-form layui-card-header layuiadmin-card-header-auto">
                  <div class="layui-form-item">
                    <label class="layui-form-label" style="text-align:left;padding-left:0px;width:50px;  ">事件：</label>
                      <div class="layui-input-inline">
                      <?php foreach($event as $ke=>$vo){ ?>
                        <a class="layui-btn layuiadmin-btn-role <?php if($re['state']==$vo['id']) echo '';else echo 'layui_back'?> event_state" data-type="add" data-id="<?php echo $vo['id']?>" data-terminal_id="<?php echo $re['id']?>" ><?php echo $vo['name']?></a>
                      <?php }?>
                      </div>
                  </div>
                </div>
              </form>
          </div>
        </div>
        </div>
        </div>
        <div class="layui-form-item">
        <pre id="result"></pre>
        </div>
      <?php }?>
     <div class="layui-fluid">   
      <div class="layui-card">
        <div class="layui-card-body">
         
          
          
          <div class="layui-form-item">
                  <label class="layui-form-label" style="text-align:left;">属性：</label>
           </div>
          <div class="layui-form layui-border-box layui-table-view" lay-filter="LAY-table-4" lay-id="LAY-user-back-role" style=" ">
            <div class="layui-table-box">
              <div class="layui-table-body">
                <table cellspacing="0" cellpadding="0" border="0" class="layui-table" style="width:100%">
                  <tbody >
                    <tr>
                      <?php foreach($rer as $ke=>$vo){  ?>
                        <th data-field="id" data-key="4-0-2" class="layui-unselect" colspan="25" style="text-align:center;padding:15px 0;">
                          <?php if($vo['Field']=='id'){?>
                            <h5>ID</h5>
                          <?php  } else{ ?>
                            <h5><?= $vo['Comment'] ?></h5>
                          <?php  }  ?>
                        </th>
                      <?php }?>
                    </tr>

                    <?php foreach ($arr_lists as $ke => $vo) { ?>
                    <tr>
                      <?php foreach($rer as $k=>$v){  ?>
                        <td data-field="id" data-key="4-0-2" class="layui-unselect" colspan="25" style="text-align:center;padding:15px 0;">
                            <span><?= $vo[$v['Field']]?></span>
                        </td>
                      <?php }?>
                    </tr>
                    <?php }  ?>

                    
                  </tbody>
                </table>
                <div class="dd-pages-wrap pc-m3">
                  <?php echo $pages; ?>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <script src="./attms/ms/layuiadmin/layui/layui.js"></script>  
    <script src="./attms/ms/js/jquery.min.js"></script>  
    <script>
      layui.config({
        base: './attms/ms/layuiadmin/' //静态资源所在路径
      }).extend({
        index: 'lib/index' //主入口模块
      }).use(['index', 'laydate', 'upload', 'form'], function () {

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
        form.on('select(louceng)', function(data){
          window.location.href="index.php?c=building&a=room&floor_id="+data.value;
        })

        $('.event_state').on('click',function(){
          var state_id=$(this).attr('data-id');
          var terminal_id=$(this).attr('data-terminal_id');
          $(this).addClass('event_state_on');
        //  onclick="window.location.href = '<?php echo pfUrl("", "terminal", "state_edit",array('terminal_id'=>$re['id'],'state_id'=>$vo['id']))?>'"
              $.ajax({
                  type: 'POST',
                  url: './index.php?c=terminal&a=state_edit',
                  dataType: 'json',
                  data: {state_id: state_id,terminal_id:terminal_id},
                  success: function (response)
                  {
                    $('.event_state').addClass('layui_back');
                    $('.event_state_on').removeClass('layui_back');
                    $('.event_state').removeClass('event_state_on');
                    console.log(response.data);
                    $('#result').html(syntaxHighlight(response.data));
                    layer.msg(response.description);
                    
                  },
                  error: function (data)
                  {
                    layer.msg(data.description);
                  }
            });
      
        });



      });

      function syntaxHighlight(json) {
          if (typeof json != 'string') {
              json = JSON.stringify(json, undefined, 2);
          }
          json = json.replace(/&/g, '&').replace(/</g, '<').replace(/>/g, '>');
          return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g,
              function(match) {
                  var cls = 'number';
                  if (/^"/.test(match)) {
                      if (/:$/.test(match)) {
                          cls = 'key';
                      } else {
                          cls = 'string';
                      }
                  } else if (/true|false/.test(match)) {
                      cls = 'boolean';
                  } else if (/null/.test(match)) {
                      cls = 'null';
                  }
                  return '<span class="' + cls + '">' + match + '</span>';
              }
          );
      }

      
    </script>
  </body>
</html>


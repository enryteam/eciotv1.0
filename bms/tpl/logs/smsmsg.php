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
        .laytable-cell-4-0-0 {
            width: 48px;
        }

        .laytable-cell-4-0-1 {
            width: 80px;
        }

        .laytable-cell-4-0-2 {}

        .laytable-cell-4-0-3 {}

        .laytable-cell-4-0-4 {}

        .laytable-cell-4-0-5 {
            width: 150px;
        }

        .layer_box {
            position: absolute;
            background: red;
            width: 100px;
            height: 100px;
            left: 8%;
            z-index: 9999999;
        }
        td{padding: 10px!important;}
    </style>
</head>

<body>

    <div class="layui-fluid">
        <div class="layui-card">

            <div class="layui-card-body">
                <div style="padding-bottom: 10px;">
                    <form name="searchform" action="index.php?c=star&amp;a=index" method="POST">
                        <div class="layui-form layui-card-header layuiadmin-card-header-auto">
                            <div class="layui-form-item">
                                <!--                  <a class="layui-btn layuiadmin-btn-role" data-type="add" onclick="window.location.href = 'index.php?c=terminal&a=gateway_edit&school_id='">添加网关</a>-->
                                <button type="button" class="layui-btn layui-btn-primary">通知消息日志</button>
                                <button type="button" class="layui-btn layui-btn-normal " onclick="window.location.reload()">刷新查看日志</button>
                            </div>
                        </div>

                    </form>

                </div>
                <div class="layui-form layui-border-box layui-table-view" lay-filter="LAY-table-4" lay-id="LAY-user-back-role" style=" ">
                    <div class="layui-table-box">
                        <div class="layui-table-body" style="overflow:auto; ">
                            <table cellspacing="0" cellpadding="0" border="0" class="layui-table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>
                                        日志内容
                                    </th>
                                </tr>
                            </thead>
                            <?php 
                                        $logs = file_get_contents('../service/log/sms_'.date("Ymd").'.log');
                                        if($logs)
                                        {
                                            $logArr = explode("\r\n",$logs);
                                            if($logArr)
                                            { 
                                                $i=1;
                                                foreach($logArr as $key=>$row){
                                                  if(count($logArr)-$key<100){ 
                                                     $i=count($logArr)-($key+1);
                                                    ?>
                                                        <?php if($i%2==0){ ?>
                                                            <thead>
                                                                <tr>
                                                                    <td>
                                                                    <?php echo $logArr[$i]; ?>
                                                                    </td>
                                                                </tr>
                                                            </thead>
                                                        <?php }else{ ?>
                                                            <tbody id="check_box">
                                                                <tr data-index="0" class="">
                                                                    <td>
                                                                    <?php  echo $logArr[$i]; ?>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        <?php
                                                        }
                                                       
                                                    }
                                                    $i++;
                                                }
                                            }
                                            else 
                                            {
                                                echo $logs;
                                            }
                                        }
                                        else 
                                        {
                                            echo '数据为空...';
                                        }
                                        ?>
                            </table>
                            
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>
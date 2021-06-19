<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ECIOT V3.0</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            border: none;
            text-decoration: none;
            list-style: none;
        }

        img {
            object-fit: cover;
        }

        html,
        body {
            width: 100%;
            height: 100%;
        }

        .temperature {
            padding: 30px;
            display: flex;
            justify-content: space-between;
            column-gap: 40px;
            background-color: #fff;
        }

        .temperature-left {
            flex: 0.5;
            display: flex;
        }

        .temperature-right {
            flex: 1.5;
        }

        .temperature_tab {
            display: flex;
            flex-direction: column;
            row-gap: 14px;
        }

        .temperature-item {
            border-radius: 8px;
            border: 1px solid rgb(236, 240, 248);
            transition: all 0.9s;
        }

        .temperature-item:hover {
            box-shadow: 8px 5px 17px 0px #cccccc;
        }

        .temperature-item-title {
            padding: 20px 20px;
            font-size: 18px;
            border-bottom: 1px solid rgb(236, 240, 248);
        }

        .temperature-item-content {
            padding: 20px 30px;
        }

        .temperature-bottom {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr;
            column-gap: 8px;
            row-gap: 8px;
        }

        .temperature-bottom-item {
            border-radius: 8px;
            border: 1px solid rgb(236, 240, 248);
            padding: 10px;
            padding-top: 14px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
            position: relative;
        }

        .temperature-bottom-item-online {
            position: absolute;
            top: 14px;
            left: 10px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            border: 1px solid green;
            background-color: green;
        }
        .temperature-bottom-item-offline {
            position: absolute;
            top: 14px;
            left: 10px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            border: 1px solid red;
            background-color: red;
        }

        .temperature-bottom-item-title {
            font-size: 12px;
        }

        .temperature-bottom-item-img {
            margin-bottom: 8px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .temperature-bottom-item-Text {
            font-size: 12px;
            margin: 6px 0;
        }

        .temperature-bottom-item-progress {
            width: 100%;
            height: 10px;
            border-radius: 20px;
            background-color: rgb(230, 235, 245);
            position: relative;
        }

        .temperature-bottom-item-progress-item {
            position: absolute;
            height: 100%;
            border-radius: 20px;
            left: 0;
            top: 0;
            background-color: #1E9FFF;
        }

        .progress-item-origin {
            background-color: #FF5722!important;
        }

        .progress-item-yellow {
            background-color: rgb(255, 255, 0) !important;
        }

        .progress-item-red {
            background-color: rgb(255, 69, 0) !important;
        }

        .temperature-bottom-item-img-drop {
            width: 24px;
        }

        .temperature-bottom-item-img-thermometer {
            width: 24px;
        }
        .temperature-bottom-item-img-U{
            width: 24px;
        }

        .temperature-bottom-item-button {
            margin-bottom: 6px;
            border-radius: 8px;
            color: #FFFFFF;
            font-size: 12px;
            padding: 5px 10px;
            margin: 0 auto;
            background-color: gray;
        }
        .panel-body{border-color: rgb(236, 240, 248)!important;border-radius: 8px;}
        .gray{color:white; background: gray;};
        .onlineoff{
            border: 1px solid red;
            background-color: red;
        }
    </style>
    <!-- 引入easyui_tree插件和样式 -->
    <link rel="stylesheet" type="text/css" href="./attms/ms/css/easyui_tree.css">
    <script src="./attms/ms/js/jquery.min.js"></script>
    <script src="./attms/ms/js/easyui_tree.js"></script>
</head>

<body>
    <div class="temperature">
        <div class="temperature-left temperature_tab">
        
        <div class="easyui-panel" style="width: 300px;position: absolute;">
        <div class="temperature-item-title">所属区域</div>
            <ul id="objectTree" class="easyui-tree"></ul>
        </div>
        </div>
        <div class="temperature-right temperature_tab">
            <?php foreach($lists_all as $ke=>$vo){ //if($vo['terminal'] ){?>
            <div class="temperature-item">
                <div class="temperature-item-title"><?php echo $vo['build_name'];?></div>
                <!--滑块开始-->
                <div  class="btn-switch on " data-id="<?php echo $vo['fid']?>" style="background:#ccc;padding:10px 20px;text-aline:center;position:absolute;margin-top:-50px;margin-left:230px;" >
                    <!-- <span class="btn-switch-span" style="left:5px;position:absolute;margin-top:4px;width:20px;height:20px;border:1px solid #ccc;background:#ccc;border-radius:50%;" >&nbsp;&nbsp;&nbsp;&nbsp;</span> -->
                    开
                </div>
                <div  class="btn-switch off " data-id="<?php echo $vo['fid']?>" style="background:#ccc;padding:10px 20px;text-aline:center;position:absolute;margin-top:-50px;margin-left:300px;" >
                    <!-- <span class="btn-switch-span" style="left:5px;position:absolute;margin-top:4px;width:20px;height:20px;border:1px solid #ccc;background:#ccc;border-radius:50%;" >&nbsp;&nbsp;&nbsp;&nbsp;</span> -->
                    关
                </div>
                <!--滑块结束-->
                <div class="temperature-item-content">
                    <div class="temperature-bottom">
                        <?php  
                        foreach($vo['terminal'] as $k=>$v){ ?>
                        <div class="temperature-bottom-item debug " data-id="<?php echo $v['id']?>" data-name="<?php echo $v['name']?>" data-product_id="<?php echo $v['product_id']?>">
                            <div class="temperature-bottom-item-online <?php echo  $v['online']==1?'':'onlineoff'?>"></div>
                            <?php 
                            if($v['state']){if($v['state']['name']=='开'){
                                ?>
                                <div class="temperature-bottom-item-img">
                                    <img style="width:30px;height: 15px;" src="./attms/ms/img/switch1.png" alt="">
                                </div>
                            <?php }else{
                                ?>
                                <div class="temperature-bottom-item-img" >
                                    <img style="width:30px;height: 15px;" src="./attms/ms/img/switch.png" alt="">
                                </div>
                            <?php }?>
                            <div class="temperature-bottom-item-Text " style="margin-bottom:auto;">
                                <?php echo $v['name']?>
                            </div>
                            <div class="temperature-bottom-item-button " style="margin-top:10px;">
                                <?php echo '设备SN'?>
                                <?php echo $v['sn']?>
                            </div>
                            <?php }else{  ?>
                                <!--根据产品 去查找对应的图标 及名称和数据-->
                                <div class="temperature-bottom-item-img">
                                    <img style="width:30px;height: 15px;" src="<?php echo $v['state']['image']?$v['state']['image']:'http://eciot.oss-cn-shanghai.aliyuncs.com/attms/ms/img/temperature/drop.png'?>" alt="">
                                </div>
                                <div class="temperature-bottom-item-Text" style="margin-bottom:auto;">
                                    <?php echo $v['name']?>
                                </div>
                                <div class="temperature-bottom-item-button " style="margin-top:10px;">
                                    <?php echo '设备SN'?>
                                    <?php echo $v['sn']?>
                                </div>
                            <?php 
                        } ?>
                        </div>
                        <?php     }  ?>
                    </div>
                </div>
            </div>
            <?php 
        file_put_contents("ddddd.log","44\n".date("His")."\n",FILE_APPEND);
        } //} ?>
            
        </div>
    </div>
</body>
<script src="./attms/ms/layuiadmin/layui/layui.js"></script>  
    <!-- <script src="./attms/ms/js/jquery.min.js"></script>   -->
    <script>
        layui.config({
            base: './attms/ms/layuiadmin/' //静态资源所在路径
        }).extend({
            index: 'lib/index' //主入口模块
        }).use(['index', 'laydate', 'upload'], function () {

            var laydate = layui.laydate;
            var upload = layui.upload;
            //常规用法
            laydate.render({
            elem: '#test-laydate-normal-cn'
            });
            laydate.render({
            elem: '#test-laydate-normal-cn1'
            });

            $('.debug').on('click',function (){
            var terminal_name=$(this).attr('data-name');
            var id=$(this).attr('data-id');
            var product_id=$(this).attr('data-product_id');
            console.log(id+'^^^^^^'+terminal_name+'&&&&'+product_id);
            layer.open({
                type: 2
                ,title: terminal_name+'的设备调试'
                ,content: './index.php?c=terminal&a=lists&product_id='+product_id+'&id='+id
                ,maxmin: true
                ,area: ['1000px', '550px']
                // ,btn: ['确定', '取消']
                ,cancel: function(index, layero){
                    window.location.reload();
                    layer.closeAll();
                }


                });
            });

            ////****  开关触发   ****************/
            /* 监听指定开关 */
            $(".btn-switch").on('click',function(){
                var on=$(this).hasClass("on");
                var building_id=$(this).attr("data-id");
                if(on){
                    $('.btn-switch').css("background","#ccc");
                    $(this).css("background","#1E9FFF");
                    $('.btn-switch').css("color","black");
                    $(this).css("color","#fff");
                    //触发总开关  todo
                    $.ajax({
                        type: "get",
                        url: "./index.php?c=dashboard&a=device_open&building_id="+building_id+"&online=1",
                        dataType: "json",
                        success: function (data) {
                            if(data.errorCode==500){
                                layer.msg(data.description);
                            }else{
                                layer.msg(data.description);
                            }
                        }
                    });
                }else{
                    $('.btn-switch').css("background","#ccc");
                    $(this).css("background","#1E9FFF");
                    $('.btn-switch').css("color","black");
                    $(this).css("color","#fff");
                    //触发总开关  todo
                    $.ajax({
                        type: "get",
                        url: "./index.php?c=dashboard&a=device_open&building_id="+building_id+"&online=2",
                        dataType: "json",
                        success: function (data) {
                            if(data.errorCode==500){
                                layer.msg(data.description);
                            }else{
                                layer.msg(data.description);
                            }
                        }
                    });
                }
            });


        });
    window.onload = function () {
        createTree();
    }

    function createTree() {
        $.ajax({
            type: "get",
            url: "./index.php?c=dashboard&a=building_all",
            dataType: "json",
            success: function (d) {
                // console.log(JSON.parse(d.data));
                console.log(d.data);
                $('#objectTree').tree({
                    data: d.data,
                    onClick: function (node, checked) {
                        var id = node.id;
						console.log(id+'-------id-------');
                        window.location.href='./index.php?c=dashboard&a=building&building_id='+id;
                    }
                })
            }
        });
    }

</script>
</html>
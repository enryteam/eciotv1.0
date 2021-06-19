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
            flex: 1.0;
            display: flex;
        }

        .temperature-right {
            flex: 1.0;
        }

        .temperature_tab {
            display: flex;
            /* flex-direction: column; */
            row-gap: 14px;
            justify-content: left;
            /* width: 45%; */
            align-items: stretch;
            flex-wrap: wrap;
        }

        .temperature-item {
            border-radius: 8px;
            border: 1px solid rgb(236, 240, 248);
            transition: all 0.9s;
            width:45%;
            margin:5px 10px;
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
            grid-template-columns: 1fr 1fr 1fr;
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
            color: #fff;
            font-size: 12px;
            padding: 5px 10px;
            margin: 0 auto;
            background-color: gray;
        }
        .panel-body{border-color: rgb(236, 240, 248)!important;border-radius: 8px;}
        .gray{color:white; background: gray;};

        /**滑块样式 */
        /* .btn-switch{
            width:100px;height:30px;border:1px solid #ccc;border-radius:13px; background:#ccc;position:absolute;margin-top:-50px;margin-left:400px;
        } */
        /**********/
    </style>
    <!-- 引入easyui_tree插件和样式 -->
    <link rel="stylesheet" type="text/css" href="./attms/ms/css/easyui_tree.css">
    <script src="./attms/ms/js/jquery.min.js"></script>
    <script src="./attms/ms/js/easyui_tree.js"></script>
</head>

<body>
    
    <div class="temperature">
    <div class="temperature-left temperature_tab">
            <?php foreach($res as $key=>$val){  if($val['product']){?>
            <?php foreach($val['product'] as $ke=>$vo){ ?>
            <div class="temperature-item">
                <div class="temperature-item-title">
                    <?php echo $vo['prodcut_catename']?>
                   
                </div>
                 <!--滑块开始-->
                 <?php if($vo['product_state']){?>
                 <div  class="btn-switch on " data-id="<?php echo $vo['id']?>" style="background:#ccc;padding:10px 20px;text-aline:center;position:absolute;margin-top:-50px;margin-left:230px;" >
                    <!-- <span class="btn-switch-span" style="left:5px;position:absolute;margin-top:4px;width:20px;height:20px;border:1px solid #ccc;background:#ccc;border-radius:50%;" >&nbsp;&nbsp;&nbsp;&nbsp;</span> -->
                    开
                </div>
                <div  class="btn-switch off " data-id="<?php echo $vo['id']?>" style="background:#ccc;padding:10px 20px;text-aline:center;position:absolute;margin-top:-50px;margin-left:300px;" >
                    <!-- <span class="btn-switch-span" style="left:5px;position:absolute;margin-top:4px;width:20px;height:20px;border:1px solid #ccc;background:#ccc;border-radius:50%;" >&nbsp;&nbsp;&nbsp;&nbsp;</span> -->
                    关
                </div>
                 <!-- <div  class="btn-switch off" data-id="<?php echo $vo['id']?>" style="width:100px;height:30px;border:1px solid #ccc;border-radius:13px;position:absolute;margin-top:-50px;margin-left:200px;" >
                </div> -->
                <?php } ?>
                <!--滑块结束-->
                <div class="temperature-item-content">
                    <div class="temperature-bottom">
                        <?php if($vo['terminal']){ foreach($vo['terminal'] as $k=>$v){
                          //  $state=D('Bms')->queryone("select * from eciot_product_state where id='".$v['state']."' and product_id='".$v['product_id']."'");
                            ?>
                            <div class="temperature-bottom-item debug " style="width:130px;" data-id="<?php echo $v['id']?>" data-name="<?php echo $v['name']?>" data-product_id="<?php echo $v['product_id']?>">
                                <div class="temperature-bottom-item-online <?php echo  $v['online']==1?'':'onlineoff'?>"></div>
                                <?php if($v['state']){if($v['state']['name']=='开'){?>
                                    <div class="temperature-bottom-item-img">
                                        <img style="width:30px;height: 15px;" src="./attms/ms/img/switch1.png" alt="">
                                    </div>
                                <?php }else{?>
                                    <div class="temperature-bottom-item-img" >
                                        <img style="width:30px;height: 15px;" src="./attms/ms/img/switch.png" alt="">
                                    </div>
                                <?php } ?>
                                <div class="temperature-bottom-item-Text" style="margin-bottom:auto;">
                                    <?php echo $v['name']?>
                                </div>
                                <div class="temperature-bottom-item-button " style="margin-top:10px;">
                                    <?php echo '设备SN'?>
                                    <?php echo $v['sn']?>
                                </div>
                                <!-- <div class="temperature-bottom-item-button <?php echo $v['state']['name']=='开'?'':'gray' ?>">
                                    <?php echo $v['state']['name']?>
                                </div> -->
                                <?php }else{ 
                                    // $product=D('Bms')->queryone("select * from eciot_product where id='".$v['product_id']."'");
                                    // $re=D('Bms')->queryone("select * from `eciot_product_".$product['id']."` where terminal_id='".$v['id']."' order by id desc");
                                    ?>
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
                                   
                                <?php } ?>
                            </div>
                        <?php } } ?>
                       

                    </div>
                </div>
            </div>
            <?php } } }?>


          
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
        }).use(['index', 'laydate','form', 'upload'], function () {

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
                var product_id=$(this).attr("data-id");
                if(on){
                    $('.btn-switch').css("background","#ccc");
                    $(this).css("background","#1E9FFF");
                    $('.btn-switch').css("color","black");
                    $(this).css("color","#fff");
                    // $(this).css("border","1px solid #ccc");
                    // $(this).find('.btn-switch-span').css('left','5px');
                    // $(this).find('.btn-switch-span').css('background','#ccc');
                    // $(this).removeClass("on");
                    // $(this).addClass("off");
                    //触发总开关  todo
                    $.ajax({
                        type: "get",
                        url: "./index.php?c=dashboard&a=device_open&product_id="+product_id+"&online=1",
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
                    // $(this).find('.btn-switch-span').css('right','5px');
                    // $(this).find('.btn-switch-span').css('background','#fff');
                    // $(this).removeClass("off");
                    // $(this).addClass("on");
                    //触发总开关  todo
                    $.ajax({
                        type: "get",
                        url: "./index.php?c=dashboard&a=device_open&product_id="+product_id+"&online=2",
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
            url: "./attms/easy_tree_demo.json",
            dataType: "json",
            success: function (d) {
                $('#objectTree').tree({
                    data: d,
                    onClick: function (node, checked) {
                        var id = node.id;
						console.log(id);
                    }
                })
            }
        });
    }

</script>
</html>
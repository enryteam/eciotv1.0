<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eciot V3.0</title>
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
            width: 50px!important;
            height: 50px!important;
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
            flex: 0.8;
            display: flex;
        }

        .temperature-right {
            flex: 1.2;
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
            grid-template-columns: 1fr 1fr 1fr 1fr 1fr;
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
            background-color: #FF5722 !important;
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

        .temperature-bottom-item-img-U {
            width: 24px;
        }

        .temperature-bottom-item-button {
            margin-bottom: 6px;
            border-radius: 8px;
            color: #FFFFFF;
            font-size: 12px;
            padding: 5px 10px;
            margin: 7px auto;
            background-color: #1E9FFF;
        }

        .panel-body {
            border-color: rgb(236, 240, 248) !important;
            border-radius: 8px;
        }

        .gray {
            color: white;
            background: gray;
        }

        ;

        .onlineoff {
            border: 1px solid red;
            background-color: red;
        }
    </style>

</head>

<body>
    <div class="temperature">
        <div class="temperature-left temperature_tab">

            <div class="temperature-item">
                <div class="temperature-item-title">设备分析</div>
                <div class="temperature-item-content" id="container_sbfx" style="height: 220px;padding:5px;"></div>
            </div>
            <div class="temperature-item">
                <div class="temperature-item-title">设备数量</div>
                <div class="temperature-item-content" id="container_sbsl" style="height: 220px;padding:5px;"></div>
            </div>
        </div>
        <div class="temperature-right temperature_tab">
            <div class="temperature-item">
                <div class="temperature-item-title">设备故障</div>
                <div class="temperature-item-content">
                    <div class="temperature-bottom">
                        <div class="temperature-bottom-item debug " data-id="1" data-name="光照传感器" data-product_id="13">
                            <div class="temperature-bottom-item-offline "></div>
                            <div class="temperature-bottom-item-img">
                                <img style="width:30px;height: 15px;" src="../attms/upfile/2021/04/23/1619192830225.jpg" alt="">
                            </div>
                            <div class="temperature-bottom-item-Text" style="margin-bottom:auto;">
                                光照传感器 </div> 
                            <div class="temperature-bottom-item-button gray">
                                设备SN：LZj84H7Gtk </div>
                        </div>
                        <div class="temperature-bottom-item debug " data-id="1" data-name="温湿度传感器" data-product_id="13">
                            <div class="temperature-bottom-item-offline "></div>
                            <div class="temperature-bottom-item-img">
                                <img style="width:30px;height: 15px;" src="../attms/upfile/2021/04/23/1619192830225.jpg" alt="">
                            </div>
                            <div class="temperature-bottom-item-Text" style="margin-bottom:auto;">
                                温湿度传感器 </div>
                            <div class="temperature-bottom-item-button gray">
                                设备SN：hRwkkbY1W7 </div>
                        </div>
                        <div class="temperature-bottom-item debug " data-id="1" data-name="空气质量传感器" data-product_id="13">
                            <div class="temperature-bottom-item-offline "></div>
                            <div class="temperature-bottom-item-img">
                                <img style="width:30px;height: 15px;" src="../attms/upfile/2021/04/23/1619192830225.jpg" alt="">
                            </div>
                            <div class="temperature-bottom-item-Text" style="margin-bottom:auto;">
                            空气质量传感器 </div>
                            <div class="temperature-bottom-item-button gray">
                                设备SN：K9QhwvreOw </div>
                        </div>
                        <div class="temperature-bottom-item debug " data-id="1" data-name="土壤传感器" data-product_id="13">
                            <div class="temperature-bottom-item-offline "></div>
                            <div class="temperature-bottom-item-img">
                                <img style="width:30px;height: 15px;" src="../attms/upfile/2021/04/23/1619192830225.jpg" alt="">
                            </div>
                            <div class="temperature-bottom-item-Text" style="margin-bottom:auto;">
                                土壤传感器 </div>
                            <div class="temperature-bottom-item-button gray">
                                设备SN：oEbi3oWzcz </div>
                        </div>
                        <div class="temperature-bottom-item debug " data-id="1" data-name="水质传感器" data-product_id="13">
                            <div class="temperature-bottom-item-offline "></div>
                            <div class="temperature-bottom-item-img">
                                <img style="width:30px;height: 15px;" src="../attms/upfile/2021/04/23/1619192830225.jpg" alt="">
                            </div>
                            <div class="temperature-bottom-item-Text" style="margin-bottom:auto;">
                                水质传感器 </div>
                            <div class="temperature-bottom-item-button gray">
                                设备SN：7ZPSgzxH3m </div>
                        </div>



                    </div>
                </div>
            </div>
            <div class="temperature-item">
                <div class="temperature-item">
                    <div class="temperature-item-title">设备消息</div>
                    <div class="temperature-item-content" id="container_sbxx" style="height: 255px;padding:5px;"></div>
                </div>
            </div>

        </div>
    </div>
</body>
<script src="./attms/ms/js/echarts.min.js"></script>
<script src="./attms/ms/js/jquery.min.js"></script>
<script src="./attms/ms/layuiadmin/layui/layui.js"></script>
<script>
    layui.config({
        base: './attms/ms/layuiadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'laydate', 'upload'], function() {

        var laydate = layui.laydate;
        var upload = layui.upload;
        //常规用法
        laydate.render({
            elem: '#test-laydate-normal-cn'
        });
        laydate.render({
            elem: '#test-laydate-normal-cn1'
        });




    });
    //设备分析/////////////////
    var dom = document.getElementById("container_sbfx");
    var myChart = echarts.init(dom);
    var app = {};

    var option;



    option = {
        tooltip: {
            trigger: 'item'
        },
        legend: {
            top: '5%',
            left: 'center'
        },
        series: [{
            name: '',
            type: 'pie',
            radius: ['40%', '70%'],
            avoidLabelOverlap: false,
            itemStyle: {
                borderRadius: 10,
                borderColor: '#fff',
                borderWidth: 2
            },
            label: {
                show: false,
                position: 'center'
            },
            emphasis: {
                label: {
                    show: true,
                    fontSize: '16',
                    fontWeight: 'none'
                }
            },
            labelLine: {
                show: false
            },
            data: [{
                    value: 1048,
                    name: '正常'
                },
                {
                    value: 735,
                    name: '停止'
                },
                {
                    value: 580,
                    name: '故障'
                },
                {
                    value: 484,
                    name: '禁用'
                }
            ]
        }]
    };

    if (option && typeof option === 'object') {
        myChart.setOption(option);
    }
    //设备类型/////////////////
    var dom = document.getElementById("container_sbsl");
    var myChart = echarts.init(dom);
    var app = {};

    var option;



    option = {
        dataset: [{
            dimensions: ['product_name', 'terminal_numb'],
            source: [
                [' LED灯 ', 841],
                [' 光照传感器 ', 720],
                [' LED灯1 ', 241],
                [' 光照传感器2 ', 220],
                [' LED灯3 ', 141],
                [' 光照传感器5 ', 320],
                [' LED灯7 ', 441],
                [' 光照传感器8 ', 520],
            ]
        }, {
            transform: {
                type: 'sort',
                config: {
                    dimension: 'terminal_numb',
                    order: 'desc'
                }
            }
        }],
        xAxis: {
            type: 'category',
            axisLabel: {
                interval: 0,
                rotate: 30
            },
        },
        yAxis: {},
        series: {
            type: 'bar',
            encode: {
                x: 'product_name',
                y: 'terminal_numb'
            },
            datasetIndex: 1
        }
    };

    if (option && typeof option === 'object') {
        myChart.setOption(option);
    }
    //设备消息/////////////
    var dom = document.getElementById("container_sbxx");
    var myChart = echarts.init(dom);
    var app = {};

    var option;



    option = {
        title: {
            text: ''
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'cross',
                label: {
                    backgroundColor: '#6a7985'
                }
            }
        },
        legend: {
            data: ['LED灯', '光照传感器', '温湿度传感器', '警报器', '空气质量', '温湿度传感器', '警报器', '空气质量']
        },
        toolbox: {
            feature: {
                //saveAsImage: {}
            }
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        xAxis: [{
            type: 'category',
            boundaryGap: false,
            data: ['周一', '周二', '周三', '周四', '周五', '周六', '周日']
        }],
        yAxis: [{
            type: 'value'
        }],
        series: [{
                name: 'LED灯',
                type: 'line',
                stack: '总量',
                areaStyle: {},
                emphasis: {
                    focus: 'series'
                },
                data: [120, 132, 101, 134, 90, 230, 210]
            },
            {
                name: '光照传感器',
                type: 'line',
                stack: '总量',
                areaStyle: {},
                emphasis: {
                    focus: 'series'
                },
                data: [220, 182, 191, 234, 290, 330, 310]
            },
            {
                name: '温湿度传感器',
                type: 'line',
                stack: '总量',
                areaStyle: {},
                emphasis: {
                    focus: 'series'
                },
                data: [150, 232, 201, 154, 190, 330, 410]
            },
            {
                name: '警报器',
                type: 'line',
                stack: '总量',
                areaStyle: {},
                emphasis: {
                    focus: 'series'
                },
                data: [320, 332, 301, 334, 390, 330, 320]
            },
            {
                name: '空气质量',
                type: 'line',
                stack: '总量',
                label: {
                    show: true,
                    position: 'top'
                },
                areaStyle: {},
                emphasis: {
                    focus: 'series'
                },
                data: [820, 932, 901, 934, 1290, 1330, 1320]
            },
            {
                name: '温湿度传感器',
                type: 'line',
                stack: '总量',
                areaStyle: {},
                emphasis: {
                    focus: 'series'
                },
                data: [150, 232, 201, 154, 190, 330, 410]
            },
            {
                name: '警报器',
                type: 'line',
                stack: '总量',
                areaStyle: {},
                emphasis: {
                    focus: 'series'
                },
                data: [320, 332, 301, 334, 390, 330, 320]
            },
            {
                name: '空气质量',
                type: 'line',
                stack: '总量',
                label: {
                    show: true,
                    position: 'top'
                },
                areaStyle: {},
                emphasis: {
                    focus: 'series'
                },
                data: [820, 932, 901, 934, 1290, 1330, 1320]
            }
        ]
    };

    if (option && typeof option === 'object') {
        myChart.setOption(option);
    }
</script>

</html>
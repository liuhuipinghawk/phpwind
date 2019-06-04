// 饼状图
function Bar(idDom, dataBar, titleBar, colorBar) {
    var option = {
        calculable : false, // 是否启用拖拽重计算特性，默认关闭
        color: colorBar,
        legend: { // 图例
            x: 'center',
            y: 'center',
            icon: 'none',
            itemWidth: 0,
            itemHeight: 0,
            textStyle: {
                fontSize: 22,
                fontFamily: 'lcletter'
            },
            selectedMode:false,
            formatter: function() { // 标签文本格式器
                var total = 0;
                var rel_data = dataBar[1].value;
                dataBar.forEach(function(value) {
                    total += value.value;
                });
                return titleBar + ((rel_data/total)*100).toFixed(2) + '%';
            },
            data: [dataBar[0].name]
        },
        series: [ // 驱动图表生成的数据内容数组
            {
                type:'pie',
                radius: ['55%', '70%'],
                itemStyle: {
                    normal: {
                        label:{
                            show: true,
                            formatter: function(param) {
                                return  param.name;
                            },
                            textStyle : {
                                fontSize: '18'
                            }
                        }
                    }
                },
                data: dataBar
            }
        ]
    };
    // 为echarts对象加载数据
    idDom.setOption(option);
}


// 折线图
function Line(idDom, lineTitle, seriesData, lineUnit, lineColor, xData) {
    var option = {
        title : {
            text: lineTitle,
            textStyle: {
                fontSize: 16,
                fontWeight: 'normal'
            }
        },
        tooltip : { // 提示框
            trigger: 'axis',
            textStyle: {
                fontSize: 15
            },
            axisPointer: {
                type: 'cross',
                label: {
                    backgroundColor: '#ef7489'
                }
            }
        },
        legend: { // 图例
            selectedMode:false,
            right: '3%'
        },
        grid: {
            left: '1%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        color: lineColor,
        calculable : true, // 是否启用拖拽重计算特性，默认关闭
        xAxis : [  // 直角坐标系中横轴数组
            {
                type : 'category',
                boundaryGap : false,
                data : xData
            }
        ],
        yAxis : [ // 直角坐标系中纵轴数组
            {
                type : 'value',
                axisLabel: {
                    formatter: '{value}'+ lineUnit
                }
            }
        ],
        series : seriesData
    };
    // 为echarts对象加载数据
    idDom.setOption(option);
}


// 租赁饼状图
function Bar2(idDom, barTitle, barName, barColor, tipData, barData, barUnit) {
    var option = {
        title: {
            text: barTitle,
            x: 5,
            y: 5,
            textStyle:{
                fontSize:18,
                fontWeight: 'normal'
            }
        },
        color: barColor,
        backgroundColor: '#ffffff',
        padding: [10, 10],
        legend: {
            right: 10,
            y: 10,
            data: tipData,
            itemGap: 10,
            textStyle: {
                fontSize: 13
            }
        },
        series: [
            {
                name: barName,
                type:'pie',
                selectedMode: 'single',
                radius: ['35%', '55%'],
                center: ['50%','66%'],
                label: {
                    normal: {
                        formatter: function (params) {
                            var total = 0; // 总户数
                            var percent = 0; // 占比
                            barData.forEach(function (value) {
                                total += value.value;
                            });
                            percent = ((params.value/total)*100).toFixed(2);
                            return params.name + '\n' + params.value + barUnit + '\n' + percent + '%';
                        },
                        textStyle: {
                            fontSize: 15,
                            fontFamily: 'lcletter',
                            color: '#000000'
                        }
                    }
                },
                labelLine: {
                    normal: {
                        length: 8
                    }
                },
                data: barData
            }
        ]
    };

    // 为echarts对象加载数据
    idDom.setOption(option);
}


// 停车饼状图
function Bar3(idDom, barTitle, barName, barColor, tipData, barData, barUnit) {
    var option = {
        title: {
            text: barTitle,
            x: 5,
            y: 5,
            textStyle:{
                fontSize:18,
                fontWeight: 'normal'
            }
        },
        color: barColor,
        padding: [10, 10],
        legend: {
            orient: 'vertical',
            right: '12%',
            y: '5%',
            data: tipData,
            itemGap: 20,
            textStyle: {
                fontSize: 13
            }
        },
        series: [
            {
                name: barName,
                type:'pie',
                selectedMode: 'single',
                radius: ['20%', '50%'],
                center: ['40%','66%'],
                label: {
                    normal: {
                        formatter: function (params) {
                            var total = 0; // 总户数
                            var percent = 0; // 占比
                            barData.forEach(function (value) {
                                total += value.value;
                            });
                            percent = ((params.value/total)*100).toFixed(2);
                            return params.name + '\n' + params.value + barUnit + '\n' + percent + '%';
                        },
                        textStyle: {
                            fontSize: 15,
                            fontFamily: 'lcletter',
                            color: '#000000'
                        }
                    }
                },
                labelLine: {
                    normal: {
                        length: 30
                    }
                },
                data: barData
            }
        ]
    };

    // 为echarts对象加载数据
    idDom.setOption(option);
}


// 柱状图
function Bar4(idDom, barTitle, barUnit, barColor, tipData, xData, barData) {
    var option = {
        title: {
            text: barTitle,
            x: 5,
            y: 10,
            textStyle:{
                fontSize:16,
                fontWeight: 'normal'
            }
        },
        grid: {
            left: '1%',
            right: '3%',
            bottom: '8%',
            containLabel: true
        },
        color: barColor,
        legend: {
            orient: 'vertical',
            right: '3%',
            y: '0%',
            data: tipData,
            itemGap: 10,
            textStyle: {
                fontSize: 13
            }
        },
        calculable : true,
        xAxis : [
            {
                type : 'category',
                data : xData,
                axisLabel: {
                    interval: 0, // 横轴信息全部显示
                    rotate: -30, // -30度倾斜显示
                }
            }
        ],
        yAxis : [
            {
                type : 'value',
                axisLabel: {
                    formatter: '{value}'+ barUnit
                }
            }
        ],
        series : barData
    };
    // 为echarts对象加载数据
    idDom.setOption(option);

}
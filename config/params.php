<?php

return [
    'PRIVATE_KEY_STR'=>"-----BEGIN RSA PRIVATE KEY-----
MIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBALpIAZIfJPHLHx9
A4JEo6ckGhG2vR6/pXj/rzNqC1RmK9hhJQwqvgFuTTzuUnv5FQZDZUDFrW+dxS+
pYowcODyF5ODrVOm6d/363vRV0qDdIu/czKbuvYoox5a5JvU5GZw5eF+kEu/R1R
aN+UlQeBRSmfgfzUE0FW2l/hRmmtZ/LAgMBAAECgYAUT2yIa4fiKxTiGfdCLHVM
+z5uHRnSVr31dza3LmOgrNOHM1mxbRAwK+AMLXimXZO4ANGrCbsUAXjW/MINr10
7x6wWr5ApKHTD8Jkiy2tjHoHzCdCUIposEoJiZUt8DxXXrZmFpZFkLbuQ8MAs4L
aM6a+eKLaf0XZq8urTdErEXQJBAPPiReFxgV8pHhKUBixVHE+oJgUVfoiIpz2Is
/8RA2XsehcC8gL6JG6xukPP8GOs/7+bX9wlT3fHgOv6v9P34ucCQQDDiSPzl+PR
n1DHX0mNf+MtM+8jvSVWogtXuu/OUpsAOY/oq9ciwIzBrJbnvtMeBEKuFLrjPq0
VQ1rw8uXdn+N9AkEA8k1k0E9NEZZwYlTerT0CG8IbxAFO7aeXQPOIoWntzl3cDv
DGMV8Ew1Wgka8OTnmavmtIGhiXk5GK7Oj7nUUzEQJAL6s6SYNo9cyaG9C+FLHtx
zJXBWZyONmOXFflaG44/WgLDlT+QKmiZwDVVS/vNe0h+GBzYzz/YySlggIlSc9V
3QJAROF3sp1v74dSEHJBacw4elK4YcsefKVYrsFHKytUZ8TQkvNemS6nknxYNQB
QLTQECYG1gbI/xYBLSObYhjen/w==
-----END RSA PRIVATE KEY-----",   
    'PROPERTY_CODE'=>'klgrekgl1d4er22akoqdlkeplgfkorek',
    'PLATFORM_TYPE'=>1, 
    'APP_PAGE_SIZE'=>6,
    //第三方在线充值IP地址
    // 'third_url' => 'http://218.28.131.242:8088/WebService_res/PurchaseWebService.asmx',
    // 'third_url' => 'http://39.108.116.20:8081/WebService/PurchaseWebService.asmx',//远程抄表第三方云服务器
    'third_url' => 'http://218.28.131.242:8088/WebService/PurchaseWebService.asmx',//远程抄表第三方云服务器
    //第三方用电缴费楼盘ID配置，47:正商汇都中心；50:正商经开广场；
    'third_config' => [47,50,60,102],
    // 'third_config' => [47],
    'house_config' => [
        // 正商国际广场
        '1' => [
            'code' => '50024',
            //A座
            '9' => [
                '01',  // 1号楼1号进
                '02',  // 1号楼2号进
                '03',  // 1号楼3号进
                '04',  // 1号楼1号出
                '05',  // 1号楼2号出
                '06',  // 1号楼3号出
                '07',  // 1号楼步梯间
                '08',  // 1号楼后门
            ],
            // B座
            '10' => [
                '09',  // 2号楼1号进
                '10',  // 2号楼2号进
                '11',  // 2号楼3号进
                '12',  // 2号楼1号出
                '13',  // 2号楼2号出
                '14',  // 2号楼步梯间
                '15',  // 2号楼后门
            ]
        ],
        // 蓝海
        '2' => [
            'code' => '50021', //蓝海社区ID
            // '21' => ['in'=>'01','out'=>'02','dt'=>'804'],   //1栋
            // '22' => ['in'=>'03','out'=>'04','dt'=>'804'],   //2栋

            // 1栋
            '21' => [
                '01',  // 1号楼1号进
                '02',  // 1号楼1号出
                '03',  // 1号楼2号进
                '04',  // 1号楼2号出
                '05',  // 1号楼3号进
                '06',  // 1号楼3号出
                '11',  // 1号楼大堂步梯间
                '12',  // 1号楼1楼货梯间
                '17',  // 1号楼西步梯
                '18',  // 1号楼负一客梯厅
                '19',  // 1号楼负一货梯厅
                '20',  // 1号楼负二客梯厅
                '801', // 1号楼A梯
                '802', // 1号楼B梯
                '803', // 1号楼C梯
                '804', // 1号楼D梯
                '805', // 1号楼E梯
                '806', // 1号楼F梯
                '807', // 1号楼货梯
            ],
            // 2栋
            '22' => [
                '07',  // 2号楼1号进
                '08',  // 2号楼1号出
                '09',  // 2号楼2号进
                '10',  // 2号楼2号出
                '13',  // 2号楼大堂步梯间
                '14',  // 2号楼外侧门
                '15',  // 2号楼负二电梯间
                '16',  // 2号楼负三电梯间
                '21',  // 2号楼负一客梯厅
                '808', // 2号楼客梯
                '809', // 2号楼货梯
            ]
        ],
        // 正商和谐大厦（供富士闸机接口调用）
        '3' => [
            'SmallCode' => 'G10000ZSJTS1000XYWY1',
            'SmallCodeId' => 'small_4hi41d6j9bBf1g4AiF19Af0f6Ah0',

            'code' => '50026',

            '23' => [
                '01',
                '02',
                '03',
                '04',
                '05',
                '06',
                '07',
                '08',
                '09',
                '10',
                '11',
                '12',
                '13'
            ],

            '24' => [
                '14','15','16','17','18','19','20','21','22','23','24','25','26'
            ]

        ],
        //航海广场
        '4' => [
            'code' => '50025',

            '27' => [
                '01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17'
            ],

            '28' => [
                '18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33','34'
            ],

            '25' => [
                '35','36','37','38','39','801','802','803'
            ],

            '26' => [
                '40','41','42','43','44','804','805','806'
            ]

        ],

        // 向阳
        '6' => [
            'code' => '50022', //向阳社区ID
            // '29' => ['in'=>'01','out'=>'02','dt'=>'804'],   //A座
            // '30' => ['in'=>'03','out'=>'04','dt'=>'804'],   //B座
            
            // A座
            '29' => [
                '01', // A座1号进
                '02', // A座1号出
                '05', // A座2号进
                '06', // A座2号出
                '11', // A座负一电梯间
                '12', // A座负一步梯间
                '13', // A座负二电梯间
                '18', // A座一楼步梯间
                '20', // A座负二步梯间
            ],
            // B座
            '30' => [
                '03', // B座1号进
                '04', // B座1号出
                '07', // B座2号进
                '08', // B座2号出
                '14', // B座负一电梯间
                '15', // B座负一步梯间
                '16', // B座负二电梯间
                '17', // B座负二中间通道
                '19', // B座一楼步梯间
            ]
        ],
        // 建正东方中心（供富士闸机接口调用）
        '7' => [
            'SmallCode' => 'G10000ZSJTS1000XYWY2',
            'SmallCodeId' => 'small_Gg5J3F167DaE1ecjf2cDDhCgfFcA',
        ],
    ],
    'award' => [
        // 'te' => '特等奖-免费停车（一个月）',
        // 'yi' => '一等奖-时尚双杯榨汁机',
        // 'er' => '二等奖-智能运动手环',
        // 'san' => '三等奖-精美乐扣水杯',
        // 'can1' => '幸运奖-余京桥口腔检查劵',
        // 'can2' => '幸运奖-高戈健身体验卡',
        // 'kong' => '谢谢参与',
        // 'thanks' => '谢谢参与',
        // 
        'te' => '特等奖-免费停车券(一个月)',
        'yi' => '一等奖-空气加湿器',
        'er' => '二等奖-电热水壶',
        'san' => '三等奖-人体电子秤',
        'can1' => '幸运奖-小夜灯',
        'can2' => '幸运奖-小夜灯',
        'kong' => '谢谢参与',
        'thanks' => '谢谢参与',
    ],
    'haoxiangkaimen' => [
        'houseids' => [1,2,3,4,6],
        // 国际
        '1' => [
            'item' => 50024,
            '9' => [ //A座
                'accesslist' => [5002401,5002402,5002403,5002404,5002405,5002406,5002407,5002408], // 门禁
            ],
            // B座
            '10' => [
                'accesslist' => [5002409,5002410,5002411,5002412,5002413,5002414,5002415], // 门禁
            ]
        ],
        // 蓝海
        '2' => [
            'item' => 50021,
            '21' => [ // 1栋
                'accesslist' => [5002101,5002102,5002103,5002104,5002105,5002106,5002111,5002112,5002117,5002118,5002119,5002120], // 门禁
                'ladderlist' => [50021801,50021802,50021803,50021804,50021805,50021806,50021807] // 电梯
            ],
            '22' => [ // 2栋
                'accesslist' => [5002107,5002108,5002109,5002110,5002113,5002114,5002115,5002116,5002121], // 门禁
                'ladderlist' => [50021808,50021809] // 电梯
            ]
        ],
        //和谐
        '3' => [
            'item' => 50026,
            '23' => [
                'accesslist' => [5002601,5002602,5002603,5002604,5002605,5002606,5002607,5002608,5002609,5002610,5002611,5002612,5002613]
            ],
            '24' => [
                'accesslist' => [5002614,5002615,5002616,5002617,5002618,5002619,5002620,5002621,5002622,5002623,5002624,5002625,5002626]
            ]
        ],
        //航海
        '4' => [
            'item' => 50025,
            '27' => [
                'accesslist' => [5002501,5002502,5002503,5002504,5002505,5002506,5002507,5002508,5002509,5002510,5002511,5002512,5002513,5002514,5002515,5002516,5002517]
            ],
            '28' => [
                'accesslist' => [5002518,5002519,5002520,5002521,5002522,5002523,5002524,5002525,5002526,5002527,5002528,5002529,5002530,5002531,5002532,5002533,5002534]
            ],
            '25' => [
                'accesslist' => [5002535,5002536,5002537,5002538,5002539],
                'ladderlist' => [50025801,50025802,50025803] // 电梯
            ],
            '26' => [
                'accesslist' => [5002540,5002541,5002542,5002543,5002544],
                'ladderlist' => [50025804,50025805,50025806] // 电梯
            ],
        ],
        // 向阳
        '6' => [
            'item' => 50022,
            '29' => [ // A座
                'accesslist' => [5002201,5002202,5002205,5002206,5002211,5002212,5002213,5002218,5002220], // 门禁
            ],
            '30' => [ // B座
                'accesslist' => [5002203,5002204,5002207,5002208,5002214,5002215,5002216,5002217,5002219], // 门禁
            ]
        ],
    ]
];

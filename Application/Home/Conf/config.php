<?php
return array(
    //'配置项'=>'配置值'
    /* 数据库设置 */
    'DB_TYPE' => 'mysql', // 数据库类型
    'DB_HOST' => '120.76.157.25', // 服务器地址
    'DB_NAME' => 'demo', // 数据库名
    'DB_USER' => 'rong', // 用户名
    'DB_PWD' => 'rong123', // 密码
    'DB_PORT' => '3306', // 端口
    'DB_PREFIX' => 'qiye_', // 数据库表前缀
    'DB_CHARSET' => 'utf8', // 数据库编码默认采用utf8
    'DB_DEBUG' => TRUE, // 数据库调试模式 开启后可以记录SQL日志

    'UPLOAD_SITEIMG_QINIU' => array(
        'maxSize' => 5 * 1024 * 1024,//文件大小
        'saveName' => time(),
        'driver' => 'Qiniu',
        'driverConfig' => array(
            'accessKey' => 'nu5CDv3gysBpE4OLGwexvxjjmDuNzI6SfSdaDQau',
            'secretKey' => 'BD15tY1oaNNOYoPlFBYp5L0tQEivCVosvfS6cn86',
            'domain' => 'pic.qiyeclass.com',
            'bucket' => 'qiyeclass',
        )
    ),

    'URL_PARAMS_BIND' => true, // URL变量绑定到Action方法参数
    'URL_ROUTER_ON' => true, // 是否开启URL路由
    'URL_ROUTE_RULES' => array(
        'qiye_index' => 'Index/index',
        'qiye_user/login' => 'User/wxLogin',//微信登录
        'qiye_lesson/allType' => 'Lesson/getAllType',//查询全部课程类型的接口
        'qiye_lesson/byType' => 'Lesson/getByType',//根据课程类型查询全部课程的接口
        'qiye_lesson/lesson' => 'Lesson/getLessonById',//查询课程下的全部视频音频的接口
        'qiye_lesson/add' => 'Lesson/add',//添加课程的接口
        'qiye_lesson/all' => 'Lesson/getAll',//查询全部推荐课程的接口

        'qiye_lessonType/add' => 'Lesson/addType',//添加课程类型的方法
        'qiye_lesson/search' => 'Lesson/searchByKey',//根据关键字查询 课程
        'qiye_payLog/ByUser' => 'PayLog/getPayLogByUser',//根据用户返回消费记录
        'qiye_stuLog/add' => 'StudyLog/add',//添加学习记录
        'qiye_stuLog/ByUser' => 'StudyLog/getByUid',//根据用户返回学习记录

        'qiye_pay/wxpay' => 'Util/wxPay',//微信jsapi支付

    ), // 默认路由规则 针对模块
);
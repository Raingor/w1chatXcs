<?php
return array(
    //'配置项'=>'配置值'
    'URL_ROUTER_ON' => true, // 是否开启URL路由
    'URL_ROUTE_RULES' => array(
        'qiye_index/:id\d' => 'Index/index',
        'qiye_user/login' => 'User/wxLogin',//微信登录
        'qiye_lesson/all' => 'Lesson/getAll',//查询全部推荐课程的接口
        'qiye_lesson/allType' => 'Lesson/getAllType',//查询全部课程类型的接口
        'qiye_lesson/byType/:typeid\d' => 'Lesson/getByType',//根据课程类型查询全部课程的接口
        'qiye_lesson/lesson/:lessonid\d' => 'Lesson/getLessonById',//查询课程下的全部视频音频的接口
        'qiye_lesson/add' => 'Lesson/add',//添加课程的接口
        'qiye_lessonType/add' => 'Lesson/addType',//添加课程类型的方法
        'qiye_lesson/search/' => 'Lesson/searchByKey',//根据关键字查询 课程
        'qiye_payLog/ByUser' => 'PayLog/getPayLogByUser',//根据用户返回消费记录
        'qiye_stuLog/add' => 'StudyLog/add',//添加学习记录
        'qiye_stuLog/ByUser' => 'StudyLog/getByUid',//根据用户返回学习记录

        'qiye_pay/wxpay' => 'Util/wxPay',//微信jsapi支付

    ), // 默认路由规则 针对模块
);
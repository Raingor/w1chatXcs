<?php
return array(
	//'配置项'=>'配置值'
    /* 数据库设置 */
    'DB_TYPE'                => 'mysql', // 数据库类型
    'DB_HOST'                => 'localhost', // 服务器地址
    'DB_NAME'                => 'demo', // 数据库名
    'DB_USER'                => 'root', // 用户名
    'DB_PWD'                 => '', // 密码
    'DB_PORT'                => '3306', // 端口
    'DB_PREFIX'              => 'qiye_', // 数据库表前缀
    'DB_FIELDS_CACHE'        => true, // 启用字段缓存
    'DB_CHARSET'             => 'utf8', // 数据库编码默认采用utf8
    'DB_DEPLOY_TYPE'         => 0, // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)

    'URL_ROUTER_ON'          => true, // 是否开启URL路由
    'URL_ROUTE_RULES'        => array(
        'qiye_index/:id\d'=>'Index/index',
        'qiye_user/add/'=>'User/addUser',//添加用户的路由
        'qiye_user/getById/:id\d'=>'User/getById',//根据id返回User对象
        'qiye_user/update'=>'User/updateUser',//修改用户信息
    ), // 默认路由规则 针对模块
);
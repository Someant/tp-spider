<?php
if (get_cfg_var('PROJECT_RUN_MODE') == 'PRODUCTION') {
    return [

    ];
} elseif (get_cfg_var('PROJECT_RUN_MODE') == 'TEST') {
    return [

    ];
} else {

    return [
        'DB_TYPE' => 'mysql',     // 数据库类型
        'DB_HOST' => 'localhost', // 服务器地址
        'DB_NAME' => 'movie',          // 数据库名
        'DB_USER' => 'homestead',      // 用户名
        'DB_PWD' => 'secret',          // 密码
        'DB_PORT' => '3306',        // 端口
        'DB_PREFIX' => '',    // 数据库表前缀,
    ];


}


<?php
if (get_cfg_var('PROJECT_RUN_MODE') == 'PRODUCTION') {
    return [
    ];
} elseif (get_cfg_var('PROJECT_RUN_MODE') == 'TEST') {
    return [
    ];
} else {
    return [
        'DATA_CACHE_PREFIX' => 'basedata:',//缓存前缀
        'DATA_CACHE_TYPE' => 'Redis',//默认动态缓存为Redis
        'REDIS_RW_SEPARATE' => false, //Redis读写分离 true 开启
        'REDIS_HOST' => '192.168.10.10', //redis服务器ip
        'REDIS_PORT' => '6379',//端口号
        'REDIS_TIMEOUT' => '300',//超时时间
        'REDIS_PERSISTENT' => false,//是否长连接 false=短连接
        'REDIS_AUTH' => '',//AUTH认证密码
        'REDIS_DATABASE' => '0',
    ];
}

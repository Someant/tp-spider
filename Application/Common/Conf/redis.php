<?php
if (get_cfg_var('PROJECT_RUN_MODE') == 'PRODUCTION'){
    return [
        'REDIS' => [
        ],
    ];
}elseif (get_cfg_var('PROJECT_RUN_MODE') == 'TEST'){
    return [
        'REDIS' => [
        ],
    ];
}else{
    return [
        'REDIS' => [
            'host' => '192.168.10.10',
            'port' => '6379',
            'password' => '',
            'database' => '0',
        ],
    ];
}

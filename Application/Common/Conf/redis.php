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
            'host' => '127.0.0.1',
            'port' => '6379',
            'password' => '',
            'database' => '0',
        ],
    ];
}

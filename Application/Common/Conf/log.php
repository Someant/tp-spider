<?php
return [
    'LOG_API_CONIFG' => array(
        'appenders' => array(
            'default' => array(
                'class' => 'LoggerAppenderDailyFile',
                'layout' => array(
                    'class' => 'LoggerLayoutPattern',
                    'params' => array(
                        'conversionPattern' => '[%date{Y-m-d H:i:s,u}][basedata][basedata.schedule][php][act][1000][%level][%msg]%n'
                    )
                ),
                'params' => array(
                    'file' => RUNTIME_PATH.'/LogOpen/schedule.api.log',
                    'append' => true,
                ),
            ),
        ),
        'rootLogger' => array(
            'level' => 'INFO',
            'appenders' => array('default')
        )
    ),
    'LOG_RESQUE_CONIFG' => array(
        'appenders' => array(
            'default' => array(
                'class' => 'LoggerAppenderDailyFile',
                'layout' => array(
                    'class' => 'LoggerLayoutPattern',
                    'params' => array(
                        'conversionPattern' => '[%date{Y-m-d H:i:s,u}][basedata][basedata.resque][php][jobid][1000][%level][%msg]%n'
                    )
                ),
                'params' => array(
                    'file' => RUNTIME_PATH.'/LogOpen/resque.biz.log',
                    'append' => true,
                ),
            ),
        ),
        'rootLogger' => array(
            'level' => 'INFO',
            'appenders' => array('default')
        )
    ),
];
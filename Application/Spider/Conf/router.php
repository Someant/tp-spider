<?php
return [
    'ROUTER' => [
        //[标识ID][调度器][工作时间][action][model][额外参数]
        1 => ['DouBan','{1-5}@[9-24]#{6,7}@[9,1]','map','DouaBan/Map'],
    ],
    'QUEUES_JOB' => [],
    'ROUTER_MAP' => ['id','scheduler','workTime','action','model','param']
];
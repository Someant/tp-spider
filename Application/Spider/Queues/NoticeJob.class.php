<?php
namespace Spider\Queues;

use Spider\Crawler\Request;
use Think\Exception;

class NoticeJob
{
    public function setUp()
    {
        // ... Set up environment for this job
    }

    public function perform()
    {
        fwrite(STDOUT, 'Start job! -> ');

        if (empty($this->args['url'])){
            throw new Exception('URL is not allowed to be empty');
        }

        if (isset($this->args['method']) and $this->args['method'] == 'post'){
            $result = Request::post($this->args['url'],$this->args['message']);
            fwrite(STDOUT, 'response:'.$result . PHP_EOL);
        }else{
            $result = Request::get($this->args['url']);
        }

        fwrite(STDOUT, 'Job ended!' . PHP_EOL);
    }

    public function tearDown()
    {
        // ... Remove environment for this job
    }

}

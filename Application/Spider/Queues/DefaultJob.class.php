<?php
namespace Spider\Queues;

use Spider\Crawler\Request;
use Think\Exception;
use Spider\Scheduler\Router;

class DefaultJob
{
    public function setUp()
    {
        // ... Set up environment for this job
        fwrite(STDOUT, 'Start job! -> ');
    }

    public function perform()
    {
        $actionId = $this->args['action_id'];
        $router = new Router($actionId,$this->args);
        $router->run();
    }

    public function tearDown()
    {
        // ... Remove environment for this job
        fwrite(STDOUT, 'Job ended!' . PHP_EOL);
    }

}

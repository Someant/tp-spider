<?php
namespace Spider\Controller;

use Spider\Scheduler\Router;
use Think\Controller;

class IndexController
{

    protected $actionId;

    public function __destruct()
    {
        //parent::__destruct();
        $this->start();
    }

    public function index()
    {
        $actionId = I('param.id');
        $this->actionId = $actionId;
        //检查是否是在工作时间 是-入队列 否-直接返回
        //队列 统一路口 通过参数启动调度器
        //调度器实现跳转到具体工作类
    }

    public function perform()
    {
        $actionId = $this->args['action_id'];
        $this->actionId = $actionId;
    }

    private function start()
    {
        $router = new Router($this->actionId);
        $router->run();
    }


}
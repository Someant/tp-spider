<?php
namespace Spider\Scheduler;

use Think\Exception;

class Router
{
    protected $actionId;
    protected $route;
    protected $instance;

    public function __construct($actionId, $args = array())
    {
        $this->actionId;
        $config = C('ROUTER')[$actionId];
        if(empty($config)){
            throw new Exception('Specified ID not found');
        }
        foreach (C('ROUTER_MAP') as $key => $value){
            $this->route[$value] = $config[$key-1];
        }
        $this->route['id'] = $actionId;
        C('ROUTE_INFO',$this->route);

        if (!empty($args)){
           Scheduler::setJobArgs($args);
        }
    }

    public function run()
    {
        if (C('SPIDER_DEBUG')){
            echo json_encode($this->route);
        }
        //$schedulerName = __NAMESPACE__.'\\'.ucfirst($this->route['scheduler']).'Scheduler';
        try{
            //$scheduler = new $schedulerName();
            //$this->instance = $scheduler;
            $scheduler = $this->getInstance();
            if(! $scheduler->times()){
                return false;
            }
            $scheduler->start($this->route);
        }catch (Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    public function getInstance()
    {
        if (! isset($this->instance)){
            $schedulerName = __NAMESPACE__.'\\'.ucfirst($this->route['scheduler']).'Scheduler';
            $this->instance = new $schedulerName();
        }

        return $this->instance;
    }

    public function setInstance($instance)
    {
        $this->instance = $instance;
    }

}
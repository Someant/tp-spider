<?php
namespace Spider\Scheduler;

class Scheduler
{
    protected $isWork = false;
    protected $route;
    protected static $modelInstance = [];

    protected static $job_args = [];


    public function __construct()
    {
        $this->isWorkTime();
    }

    public function isWorkTime()
    {
        if(empty(C('ROUTER')[1])){
            $this->isWork = true;
        }else{

        }
        return $this->isWork;
    }

    protected function formatTime()
    {

    }

    public function getRoute()
    {
        return $this->route;
    }

    public function setRoute($route)
    {
        $this->route = $route;
        C('ROUTE_INFO',$route);
    }

    public function start($param)
    {
        $this->setRoute($param);
        $this->{$this->route['action']}();
    }

    public function setParam($param)
    {
        $this->route['param'] = $param;
        $this->setRoute($this->route);
    }

    public function getParam()
    {
        return $this->route['param'];
    }

    public static function getModelInstance($modelName)
    {
        if(array_key_exists($modelName,static::$modelInstance)){
            return static::$modelInstance[$modelName];
        }

        $class = '\Spider\Model\\'.str_replace('/','\\',$modelName).'Model';
        $instance = new $class();
        static::$modelInstance[$modelName] = $instance;
        return $instance;
    }

    public static function bindModel()
    {

    }

    public static function setJobArgs($args)
    {
        self::$job_args = $args;
    }

    public static function getJobArgs()
    {
        return self::$job_args;
    }

    public function __get($key)
    {
        $callable = [
            'crawler',
        ];

        if (in_array($key, $callable) && method_exists($this, $key)) {
            return $this->$key();
        }

        throw new \Exception('Undefined property '.get_class($this).'::'.$key);
    }
}
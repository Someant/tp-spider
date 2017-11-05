<?php
namespace Spider\Listeners;

use Spider\Extension\GenerateController;
use Spider\Queues\Helper;
use Predis;
use Spider\Crawler\Request;

class EventListener
{
    use Helper;

    protected $redis;
    protected static $handle;
    protected static $message = '';

    public function __construct()
    {
        //return;
        //self::$handle = new Helper();
    }

    public static function setMessage($message)
    {
        self::$message = $message;
    }

    public static function getMessage()
    {
        return self::$message;
    }


}
<?php
namespace Spider\Controller;

use Spider\Crawler\TiCaiSpider;
use Spider\Crawler\ZhongCaiSpider;
use Spider\Extension\GenerateController;
use Spider\Extension\ValidateScheduleData;
use Spider\Listeners\EventListener;
use Spider\Queues\DefaultJob;
use Spider\Queues\Helper;
use Spider\Queues\Scheduler;
use Spider\Scheduler\NumberScheduler;
use Think\Cache\Driver\Redis;
use Think\Controller;
use PHPMailer;
use Predis;
use Think\Exception;


class TestController extends Controller
{
    use Helper;


}
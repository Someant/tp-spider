<?php
namespace Spider\Queues;

use Spider\Controller\TestController;

trait Helper
{
    protected $args;
    protected static $delayInstance;

    public function __construct()
    {
        self::instantiate();
    }

    protected static function instantiate()
    {
        date_default_timezone_set('Asia/Shanghai');
        \Resque::setBackend('redis://user:'.C('REDIS.password').'@'.C('REDIS.host').':'.C('REDIS.port').'/'.C('REDIS.database'));
    }
    
    public function addJob($actionId,$args)
    {
        $args = array(
            'time' => time(),
            'url' => $args['url'],
            'action_id' => $actionId,
            'args' => $args,
        );

        if ($actionId){
            unset($args['url']);
            $jobId = self::defaultJob($args);
        }else{
            unset($args['action_id']);
            $jobId = self::noticeJob($args);
        }

        return $jobId;
    }

    public static function addDefaultJobWithArgs($actionId,$args)
    {
        self::instantiate();
        $args['action_id'] = $actionId;
        return self::defaultJob($args);
    }

    public function addNoticeJob($url,$message,$method = 'post')
    {
        $args = array(
            'time' => time(),
            'url' => $url,
            'method' => $method,
            'message' => $message
        );

        $jobId = self::noticeJob($args);
        return $jobId;
    }

    public static function addMailJob($to, $title,$message, $isHtml = false)
    {
        self::instantiate();
        $args = array(
            'time' => time(),
            'to' => $to,
            'title' => $title,
            'message' => $message,
            'isHtml' => $isHtml
        );

        return self::mailJob($args);
    }

    public function jobStatus($id)
    {
        $status = new \Resque_Job_Status($id);

        if(! $status->isTracking()) {
            return "Resque is not tracking the status of this job.";
        }

        return $status->get();
    }

    private static function defaultJob($args)
    {
        return \Resque::enqueue('default', '\Spider\Queues\DefaultJob', $args, true);
    }

    private static function NoticeJob($args)
    {
        return \Resque::enqueue('notice', '\Spider\Queues\NoticeJob', $args, true);
    }

    private static function mailJob($args)
    {
        return \Resque::enqueue('mail', '\Spider\Queues\MailJob', $args, true);
    }
}

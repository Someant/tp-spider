<?php
namespace Spider\Controller;

use Spider\Queues\Helper;
use Spider\Scheduler\Router;
use Think\Controller;

class CronJobController extends Controller
{
    use Helper;

    public function index()
    {
        $id = I('param.id');

        if ($id){
            $this->addJob($id);
        }
    }

    public function everyFiveMinutes()
    {
        $job = C('QUEUES_JOB');

        foreach ($job as $key => $value){
            $router = new Router($value);
            $instance = $router->getInstance();
            if ($instance->times()){
                $this->addJob($value);
            }
        }
	
		$this->addJob('','http://jcdata.tigercai.com/Qiutan/CronJob/queryEuroCompanyByMin');

    }

    public function everyMinute()
    {

    }


    public function delayedJob()
    {
        require __DIR__.'/../Lib/ResqueScheduler.php';

        for ($i = 0;$i < 7;$i++){
            $in = 120 + (120 * $i);
            $args = ['action_id' => 209,'date' => date('Y-m-d',strtotime('+ '.$i.' days'))];
            \ResqueScheduler::enqueueIn($in, 'default', '\Spider\Queues\DefaultJob', $args);
            addMyLog(print_r($args,true),'delayed_job');
            unset($args,$in);
        }
    }

}
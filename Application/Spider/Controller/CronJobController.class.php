<?php
namespace Spider\Controller;

use Spider\Model\DouBan\MapModel;
use Spider\Model\DouBan\ShortCommentModel;
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

    public function test()
    {
        $category_list = D('BaseCategory')->select();
        $disable_ids = [1,2,];
        //S('test','123');
        foreach ($category_list as $item){
            if (!in_array($item['category_id'],$disable_ids)){
                continue;
            }

            $exist_data = S('empty_data:'.$item['category_id']);
            $page = 1;
            while (empty($exist_data)){
                $this->addJob(1,['page' => $page,'category_name' => $item['name'],'category_id' => $item['category_id']]);
                echo 'page:'.$page.' category_id:'.$item['category_id'].PHP_EOL;
                addMyLog('page:'.$page.' category_id:'.$item['category_id'],'test_page');
                sleep(2);
                $page++;
                $exist_data = S('empty_data:'.$item['category_id']);
            }

        }
//        for ($i = 0; $i < 300; $i++){
//            $this->addJob(1,['page' => $i,'category_name' => $category_name]);
//            echo 'page:'.$i.' category_id:'.$category_id.PHP_EOL;
//            sleep(3);
//            addMyLog('page:'.$i.' category_id:'.$category_id,'test_page');
//        }

    }

    public function ID3()
    {
        $where['category_id'] = ['in','2'];
        $map = (new MapModel())->field('outside_id,category_id')->where($where)->select();

        foreach ($map as $item){
            $this->addJob(3,['outside_id' => $item['outside_id']]);
            echo 'outside_id:'.$item['outside_id'].' category_id:'.$item['category_id'].PHP_EOL;
            addMyLog('outside_id:'.$item['outside_id'].' category_id:'.$item['category_id'],'ID3');
            sleep(2);
        }
    }

}
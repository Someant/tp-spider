<?php
namespace Spider\Scheduler;


use Spider\Convention\SchedulerInterface;
use Spider\Crawler\DouBanSpider;
use Spider\Model\DouBan\MapModel;
use Think\Exception;

class DouBanScheduler extends Scheduler implements SchedulerInterface{

    public function times()
    {
        return true;
    }

    public function queue()
    {
        // TODO: Implement queue() method.
    }

    public function map()
    {
        //todo 爬虫通信 终止 和数据交互
        $page_num = 20;
        //for ($i = 0; $i < 100; $i++){
        $i = $this->getJobArgs()['args']['page'];
        $category_id = $this->getJobArgs()['args']['category_id'];
            $this->setParam([
                'start_num' => $i * $page_num,
                'category_name' => urlencode($this->getJobArgs()['args']['category_name']),
            ]);

            $data = (new DouBanSpider())->getUrlMapByCategory($category_id);
            self::getModelInstance('DouBan/Map')->updateData($data);
            if (empty($data)){
                S('empty_data:'.$category_id,date('Y-m-d'));
                throw new Exception('No data');
            }
        //}

    }


}
<?php
namespace Spider\Scheduler;


use Spider\Convention\SchedulerInterface;

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
           
    }


}
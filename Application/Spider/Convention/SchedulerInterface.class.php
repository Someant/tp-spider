<?php
namespace Spider\Convention;

interface SchedulerInterface
{
    public function start($param);
    //public function result();
    public function times();
    public function queue();
}
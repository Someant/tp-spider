<?php
namespace Spider\Queues;

use Think\Exception;

class MailJob
{
    public function setUp()
    {
        // ... Set up environment for this job
        fwrite(STDOUT, 'Start job! -> ');
    }

    public function perform()
    {
        $result = sendMail($this->args['to'],$this->args['title'],$this->args['message'],$this->args['isHtml']);

        if (! $result){
            throw new Exception('Mail delivery failed');
        }
    }

    public function tearDown()
    {
        // ... Remove environment for this job
        fwrite(STDOUT, 'Job ended!' . PHP_EOL);
    }

}

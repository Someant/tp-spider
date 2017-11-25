<?php
namespace Spider\Model\DouBan;

use Think\Model;
use Spider\Model\BaseModel;


class ShortCommentModel extends BaseModel
{
    protected $tableName = 'douban_short_comment';
    public $idName = ['outside_id','pid'];
    public $fieldPrefix = '';
    


}
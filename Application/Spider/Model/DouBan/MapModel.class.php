<?php
namespace Spider\Model\DouBan;

use Think\Model;
use Spider\Model\BaseModel;


class MapModel extends BaseModel
{
    protected $tableName = 'douban_map';
    public $idName = ['outside_id','category_id'];
    public $fieldPrefix = '';
    


}
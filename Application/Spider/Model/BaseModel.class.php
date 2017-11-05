<?php
namespace Spider\Model;

use Think\Model;

class BaseModel extends Model
{

    protected $fillable = [];
    protected static $unguarded = false;

    public $idName = array();
    public $itemMap = array();

    protected function fillableFromArray(array $attributes)
    {
        if (count($this->fillable) > 0 && ! static::$unguarded) {
            return array_intersect_key($attributes, array_flip($this->fillable));
        }

        return $attributes;
    }

    public function existItem($data)
    {
        foreach ($this->idName as $name){
            $this->itemMap[$name] = is_array($data) ? $data[$name] : $data;
        }
        return $this->where($this->itemMap)->count();
    }

    public function transform($item)
    {
        return $item;
    }

}
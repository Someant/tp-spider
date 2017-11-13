<?php
namespace Spider\Model;

use Think\Model;

class BaseModel extends Model
{

    protected $fillable = [];
    protected static $unguarded = false;

    public $idName = array();
    public $itemMap = array();
    public static $update = true;

    public function updateData($data)
    {
        foreach ($data as $key => $item) {
            $item = $this->transform($item);
            if (!$this->existItem($item)) {
                $item[$this->fieldPrefix.'createtime'] = date('Y-m-d H:i:s');
                $this->add($item);
            }else{
                if (static::$update){
                    $item[$this->fieldPrefix.'modifytime'] = date('Y-m-d H:i:s');
                    foreach ($this->itemMap as $key){
                        unset($item[$key]);
                    }
                    $this->where($this->itemMap)->save($item);
                }
            }
        }
    }

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
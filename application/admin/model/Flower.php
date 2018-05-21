<?php

namespace app\admin\model;

use think\Model;

class Flower extends Model
{
    // 表名
    protected $name = 'flower';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    
    // 追加属性
    protected $append = [

    ];


    public function category()
    {
        return $this->belongsTo('Category', 'cate_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}

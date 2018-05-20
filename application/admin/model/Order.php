<?php

namespace app\admin\model;

use think\Model;

class Order extends Model
{
    // 表名
    protected $name = 'order';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'if_paid_text'
    ];
    

    
    public function getIfPaidList()
    {
        return ['0' => __('If_paid 0'),'1' => __('If_paid 1')];
    }     


    public function getIfPaidTextAttr($value, $data)
    {        
        $value = $value ? $value : $data['if_paid'];
        $list = $this->getIfPaidList();
        return isset($list[$value]) ? $list[$value] : '';
    }




    public function flower()
    {
        return $this->belongsTo('Flower', 'flower_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function user()
    {
        return $this->belongsTo('User', 'user_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}

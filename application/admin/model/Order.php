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
    protected $createTime = 'create_time';
    protected $updateTime = false;
// 追加属性
    protected $append = [
        'if_paid_text'
    ];

    public function setPaidTimeAttr($value, $data)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    public function setCreateTimeAttr($value, $data)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    public function getIfPaidList()
    {
        return ['0' => __('If_paid 0'), '1' => __('If_paid 1')];
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

    //尝试执行事物event(类似于laravel中的模型检测器)
    //生成订单号
    public static function makeOrderNo()
    {
        $yCode = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K'];
        $orderSn = $yCode[intval(date('Y') - 2017)] . strtoupper(dechex(date('m'))) . date('d') . substr
            (time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
        return $orderSn;
    }
}

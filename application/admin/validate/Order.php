<?php

namespace app\admin\validate;

use think\Validate;


class Order extends Validate
{
    /**
     * 验证
     */
    protected $rule = [

        'user_id'=>'require|number',
        'flower_id'=>'require|number',
        'order_sn'=>'require',
        'price'=>'require|float',
        'amount'=>'require|number|gt:0',
        'subtotal'=>'require|number',
        'if_paid'=>'require|in:1,0',
        'create_time'=>'require|date',
        'paid_time'=>'egt:create_time'

    ];
    /**
     * 提示消息
     */
    protected $message = [
        'price'=>'单价格式有误',
        'amount.gt'=>'数量必须大于0',
        'subtotal'=>'总价格式有误',
        'paid_time'=>'支付时间必须大于下单时间'

    ];
    /**
     * 验证场景
     */
    protected $scene = [
        'add'  => ['order_sn','user_id','flower_id','price','amount','subtotal','if_paid','create_time'],
        'edit' => ['order_sn','user_id','flower_id','price','amount','subtotal','if_paid','create_time','paid_time'],
    ];
    
}

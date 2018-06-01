<?php

namespace app\admin\validate;

use think\Validate;


//todo 验证器进行验证,今日因为生病,开发十分缓慢
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
        'amount'=>'require|number',
        'subtotal'=>'require|number',
        'if_paid'=>'require|in:1,0',
        'create_time'=>'require|date',
        'paid_time'=>'gt:create_time'

    ];
    /**
     * 提示消息
     */
    protected $message = [
        'price'=>'单价格式有误',
        'amount'=>'数量格式有误',
        'subtotal'=>'总价格式有误',
        'paid_time'=>'支付时间必须大于下单时间'

    ];
    /**
     * 验证场景
     */
    protected $scene = [
        'add'  => ['order_sn','user_id','flower_id','price','amount','subtotal','if_paid'],
        'edit' => ['order_sn','user_id','flower_id','price','amount','subtotal','if_paid','create_time','paid_time'],
    ];
    
}

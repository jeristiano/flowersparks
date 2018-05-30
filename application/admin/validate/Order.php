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
        'user_id'=>'require|int',
        'flower_id'=>'require|int',
        'order_sn'=>'require',
        'price'=>'require|float',
        'amount'=>'require|int',
        'subtotal'=>'require|number',
        'if_paid'=>'require|in:1,0',
        'createtime'=>'require',
        'paid_time'=>'lt:createtime'
    ];
    /**
     * 提示消息
     */
    protected $message = [

    ];
    /**
     * 验证场景
     */
    protected $scene = [
        'add'  => ['order_sn','user_id','flower_id','price','amount','subtotal','if_paid'],
        'edit' => ['order_sn','user_id','flower_id','price','amount','subtotal','if_paid','createtime','paid_time'],
    ];
    
}

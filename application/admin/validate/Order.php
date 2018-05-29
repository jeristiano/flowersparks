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
        'add'  => [],
        'edit' => [],
    ];
    
}

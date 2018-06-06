<?php

namespace app\admin\model;

//统计数据服务模型
use fast\Date;

class Calculate
{
    public static function countOrderTotalAmountThisYear()
    {
        $thisYearUnix = Date::unixtime('year', 0, 'begin');
        return Order::where('create_time', '>=', $thisYearUnix)->count();
    }

}

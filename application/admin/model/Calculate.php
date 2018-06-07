<?php

namespace app\admin\model;

//统计数据服务模型
use fast\Date;
use think\Cache;

class Calculate
{
    protected $cache = 'thisyearstat';

    public function  preOrderCalculateData()
    {
        $result = Cache::get($this->cache);
        if ($result === false) {
            $data['totaluser'] = $this->countUserAmountThisYear();
            $data['totalaverageprice'] = $this->countAveragePriceThisYear();
            $data['totalorder'] = $this->countOrderAmountThisYear();
            $data['totalorderamount'] = $this->countIncomeAmountThisYear();
            Cache::set($this->cache, $data, 7200);
            return $data;
        } else {
            return $result;
        }

    }

    public function countOrderAmountThisYear()
    {
        $thisYearUnix = self::thisYearUnix();
        return Order::where('create_time', '>=', $thisYearUnix)->count();
    }

    public function countUserAmountThisYear()
    {
        $thisYearUnix = self::thisYearUnix();
        $users = Order::where('create_time', '>=', $thisYearUnix)->column('user_id');
        return $userAmount = count(array_unique($users));
    }

    public function countIncomeAmountThisYear()
    {
        $thisYearUnix = self::thisYearUnix();
        return Order::where('create_time', '>=', $thisYearUnix)->sum('subtotal');

    }

    public function countAveragePriceThisYear()
    {
        $thisYearUnix = self::thisYearUnix();
        return Order::where('create_time', '>=', $thisYearUnix)->avg('price');

    }

    private static function thisYearUnix()
    {
        return Date::unixtime('year', 0, 'begin');
    }
}

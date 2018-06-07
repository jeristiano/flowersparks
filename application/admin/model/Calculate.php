<?php

namespace app\admin\model;

//统计数据服务模型
use fast\Date;
use think\Cache;

class Calculate
{
    protected $cache = 'thisyearstat';

    //获得统计数据缓存
    public function preOrderCalculateData()
    {
        $result = Cache::get($this->cache);
        if ($result === false) {
            $data['totaluser'] = $this->countUserAmountThisYear();
            $data['totalaverageprice'] = $this->countAveragePriceThisYear();
            $data['totalorder'] = $this->countOrderAmountThisYear();
            $data['totalorderamount'] = $this->countIncomeAmountThisYear();
            Cache::set($this->cache, $data, 3600);
            return $data;
        } else {
            return $result;
        }

    }

    //更新统计缓存供命令行调用
    public function updateCalculateCache()
    {
        $data['totaluser'] = $this->countUserAmountThisYear();
        $data['totalaverageprice'] = $this->countAveragePriceThisYear();
        $data['totalorder'] = $this->countOrderAmountThisYear();
        $data['totalorderamount'] = $this->countIncomeAmountThisYear();
        return Cache::set($this->cache, $data, 3600);
    }

    //统计订单总数
    public function countOrderAmountThisYear()
    {
        $thisYearUnix = self::thisYearUnix();
        return Order::where('create_time', '>=', $thisYearUnix)->count();
    }

    //统计客户总数
    public function countUserAmountThisYear()
    {
        $thisYearUnix = self::thisYearUnix();
        $users = Order::where('create_time', '>=', $thisYearUnix)->column('user_id');
        return $userAmount = count(array_unique($users));
    }

    //统计收入总数
    public function countIncomeAmountThisYear()
    {
        $thisYearUnix = self::thisYearUnix();
        return Order::where('create_time', '>=', $thisYearUnix)->sum('subtotal');

    }

    //统计平均价格
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

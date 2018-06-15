<?php

namespace app\admin\model;

//统计数据服务模型
use fast\Date;
use think\Cache;
use think\Db;

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
            $data['totalamount'] = $this->countAmountThisYear();
            $data['payorder'] = $this->buildPaylistAndOrderlist();
            $data['floweramount'] = $this->countFlowerAmountThisYear();
            $data['maxsubtotal'] = $this->countMaxAmountThisYear();
            $data['recentsubtotal'] = $this->count7DaysSubtotal();
            $data['recentamount'] = $this->count7DaysAmount();
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
        $data['totalamount'] = $this->countAmountThisYear();
        $data['payorder'] = $this->buildPaylistAndOrderlist();
        $data['floweramount'] = $this->countFlowerAmountThisYear();
        $data['maxsubtotal'] = $this->countMaxAmountThisYear();
        $data['recentsubtotal'] = $this->count7DaysSubtotal();
        $data['recentamount'] = $this->count7DaysAmount();
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
        $price = Order::where('create_time', '>=', $thisYearUnix)->avg('price');
        return round($price, 2);
    }

    public function countAmountThisYear()
    {
        $thisYearUnix = self::thisYearUnix();
        return Order::where('create_time', '>=', $thisYearUnix)->sum('amount');
    }

    private static function thisYearUnix()
    {
        return Date::unixtime('year', 0, 'begin');
    }

    private function recentDaysUnix($offset = 0)
    {
        return \fast\Date::unixtime('day', $offset);
    }

    //构建30天时间轴
    public function buildPaylistAndOrderlist()
    {
        $todaytime = $this->recentDaysUnix(0);
        $paylist = $createlist = [];
        $data = $this->countOrderRecentDays();
        for ($i = 0; $i < 60; $i++) {
            $day = date("Y-m-d", $todaytime - ($i * 86400));
            $paylist[$day] = 0;
            $createlist[$day] = 0;
            foreach ($data as $key => $value) {
                if ($value['fctime'] == $day) {
                    $createlist[$day] = $value['amount'];
                    $paylist[$day] = $value['subtotal'];
                }
            }

        }
        $result['createlist'] = array_reverse($createlist);
        $result['paylist'] = array_reverse($paylist);
        return $result;

    }

    //获取近30天统计数据
    public function countOrderRecentDays()
    {
        $recentDays = $this->recentDaysUnix(-59);
        $data = Db::name('order')
            ->where('create_time', '>=', $recentDays)
            ->field('sum(amount) as amount,count(order_id) as order_amount,sum(subtotal) as subtotal, FROM_UNIXTIME(create_time, \'%Y-%m-%d\')as fctime')
            ->group('fctime')
            ->select();
        return $data;
    }

    //统计今年销售的花卉种类总数
    public function countFlowerAmountThisYear()
    {
        $timeStamp = self::thisYearUnix();
        $flower = Order::where('create_time', '>=', $timeStamp)
            ->column('flower_id');
        return count(array_unique($flower));
    }

    public function countMaxAmountThisYear()
    {
        $timeStamp = self::thisYearUnix();
        $data = Db::name('order')
            ->where('create_time', '>=', $timeStamp)
            ->field('max(subtotal) as subtotal,create_time')
            ->find();
        return $data;
    }

    //近七天的销售量
    public function count7DaysAmount()
    {
        $recentDays = $this->recentDaysUnix(-7);
        $flower = Order::where('create_time', '>=', $recentDays)
            ->sum('amount');
        return $flower;
    }
    //近七天的销售量
    public function count7DaysSubtotal()
    {
        $recentDays = $this->recentDaysUnix(-7);
        $flower = Order::where('create_time', '>=', $recentDays)
            ->sum('subtotal');
        return $flower;
    }
}

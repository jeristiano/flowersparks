<?php

namespace app\admin\controller;

use app\admin\model\Calculate;
use app\common\controller\Backend;
use fast\Date;
use think\Config;

/**
 * 控制台
 * @icon fa fa-dashboard
 * @remark 用于展示当前系统中的统计数据、统计报表及重要实时数据
 */
class Dashboard extends Backend
{

    //todo 开始开发统计功能
    /**
     * 查看
     */
    public function index()
    {

        $seventtime = \fast\Date::unixtime('day', -7);
        $paylist = $createlist = [];
        for ($i = 0; $i < 7; $i++) {
            $day = date("Y-m-d", $seventtime + ($i * 86400));
            $createlist[$day] = mt_rand(20, 200);
            $paylist[$day] = mt_rand(1, mt_rand(1, $createlist[$day]));
        }
        $today = time();
        $thisYear = date('Y', $today);
        $hooks = config('addons.hooks');
        $uploadmode = isset($hooks['upload_config_init']) && $hooks['upload_config_init'] ? implode(',', $hooks['upload_config_init']) : 'local';
        $addonComposerCfg = ROOT_PATH . '/vendor/karsonzhang/fastadmin-addons/composer.json';
        Config::parse($addonComposerCfg, "json", "composer");
        $config = Config::get("composer");
        $addonVersion = isset($config['version']) ? $config['version'] : __('Unknown');

        $calculate = new Calculate();
        $data = $calculate->preOrderCalculateData();
        $this->view->assign([
            'totaluser' => $data['totaluser'],
            'totalaverageprice' => $data['totalaverageprice'],
            'totalorder' => $data['totalorder'],
            'totalorderamount' => $data['totalorderamount'],
            'todayuserlogin' => 321,
            'todayusersignup' => 430,
            'todayorder' => 2324,
            'unsettleorder' => 132,
            'sevendnu' => '77%',
            'sevendau' => '77%',
            'paylist' => $paylist,
            'createlist' => $createlist,
            'addonversion' => $addonVersion,
            'uploadmode' => $uploadmode,
            'thisyear' => $thisYear
        ]);

        return $this->view->fetch();
    }

}

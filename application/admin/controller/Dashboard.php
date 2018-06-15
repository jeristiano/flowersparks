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
            'totalamount' => $data['totalamount'],
            'floweramount' => $data['floweramount'],
            'paylist' => $data['payorder']['paylist'],
            'createlist' => $data['payorder']['createlist'],
            'addonversion' => $addonVersion,
            'uploadmode' => $uploadmode,
            'thisyear' => $thisYear,
            'maxsubtotal'=>$data['maxsubtotal'],
            'recentsubtotal'=>$data['recentsubtotal'],
            'recentamount'=>$data['recentamount']
        ]);

        return $this->view->fetch();
    }

}

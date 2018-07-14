<?php

namespace app\admin\command;

use PDO;
use think\Config;
use think\console\Command;
use think\console\Input;
use think\console\Output;
use app\admin\model\Calculate as CalculateModel;
use think\Exception;
use think\Log;

class Calculate extends Command
{

    protected $model = null;

    protected function configure()
    {
        $this->setName('calculate')
            ->setDescription('更新统计缓存');
    }

    protected function execute(Input $input, Output $output)
    {
        $data = (new CalculateModel())->updateCalculateCache();
        if ($data == false) {
            throw new Exception("统计数据更新失败");
        }
        $output->info("统计数据更新成功");
    }

}

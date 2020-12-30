<?php

declare(strict_types=1);

namespace Imi\Test\Component;

use Imi\App;
use Imi\Db\Interfaces\IDb;
use Imi\Event\Event;
use Imi\Event\EventParam;
use Imi\Pool\PoolManager;
use PHPUnit\Runner\BeforeFirstTestHook;

class PHPUnitHook implements BeforeFirstTestHook
{
    public function executeBeforeFirstTest(): void
    {
        Event::on('IMI.APP_INIT', function (EventParam $param) {
            go(function () use ($param) {
                $param->stopPropagation();
                PoolManager::use('maindb', function ($resource, IDb $db) {
                    $truncateList = [
                        'tb_article',
                        'tb_member',
                        'tb_update_time',
                        'tb_performance',
                    ];
                    foreach ($truncateList as $table)
                    {
                        $db->exec('TRUNCATE ' . $table);
                    }
                });
            });
        }, 1);
        App::run('Imi\Test\Component', TestApp::class);
    }
}
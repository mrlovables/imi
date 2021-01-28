<?php

declare(strict_types=1);

namespace Imi\Workerman\Test\AppServer\TcpServer\Controller;

use Imi\ConnectContext;
use Imi\RequestContext;
use Imi\Server\TcpServer\Route\Annotation\TcpAction;
use Imi\Server\TcpServer\Route\Annotation\TcpController;
use Imi\Server\TcpServer\Route\Annotation\TcpRoute;
use Imi\Workerman\Server\Tcp\Server;

/**
 * 数据收发测试.
 *
 * @TcpController
 */
class TestController extends \Imi\Controller\TcpController
{
    /**
     * 登录.
     *
     * @TcpAction
     * @TcpRoute({"action"="login"})
     *
     * @return void
     */
    public function login($data)
    {
        ConnectContext::set('username', $data->username);
        $this->server->joinGroup('g1', $this->data->getFd());

        return ['action' => 'login', 'success' => true, 'middlewareData' => RequestContext::get('middlewareData')];
    }

    /**
     * 发送消息.
     *
     * @TcpAction
     * @TcpRoute({"action"="send"})
     *
     * @param
     *
     * @return void
     */
    public function send($data)
    {
        /** @var Server $server */
        $server = $this->server;
        $group = $server->getGroup('g1');
        $worker = $server->getWorker();
        $message = $this->encodeMessage([
            'action'     => 'send',
            'message'    => ConnectContext::get('username') . ':' . $data->message,
        ]);
        foreach ($group->getHandler()->getFds('g1') as $fd)
        {
            $worker->connections[$fd]->send($message);
        }
    }

    /**
     * 测试重复路由警告.
     *
     * @TcpAction
     * @TcpRoute({"duplicated"="1"})
     *
     * @param
     *
     * @return void
     */
    public function duplicated1($data)
    {
    }

    /**
     * 测试重复路由警告.
     *
     * @TcpAction
     * @TcpRoute({"duplicated"="1"})
     *
     * @param
     *
     * @return void
     */
    public function duplicated2($data)
    {
    }
}
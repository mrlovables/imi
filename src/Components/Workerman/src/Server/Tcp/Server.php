<?php

declare(strict_types=1);

namespace Imi\Workerman\Server\Tcp;

use Imi\Bean\Annotation\Bean;
use Imi\Event\Event;
use Imi\RequestContext;
use Imi\Server\Protocol;
use Imi\Server\TcpServer\Contract\ITcpServer;
use Imi\Workerman\Server\Base;
use Workerman\Connection\TcpConnection;

/**
 * @Bean("WorkermanTcpServer")
 */
class Server extends Base implements ITcpServer
{
    /**
     * 获取协议名称.
     *
     * @return string
     */
    public function getProtocol(): string
    {
        return Protocol::TCP;
    }

    /**
     * 是否为长连接服务
     *
     * @return bool
     */
    public function isLongConnection(): bool
    {
        return true;
    }

    /**
     * 绑定服务器事件.
     *
     * @return void
     */
    protected function bindEvents()
    {
        parent::bindEvents();

        $this->worker->onMessage = function (TcpConnection $connection, string $data) {
            $fd = $connection->id;
            RequestContext::muiltiSet([
                'server' => $this,
                'fd'     => $fd,
            ]);
            Event::trigger('IMI.WORKERMAN.SERVER.TCP.MESSAGE', [
                'server'     => $this,
                'connection' => $connection,
                'fd'         => $fd,
                'data'       => $data,
            ], $this);
        };
    }

    /**
     * 获取实例化 Worker 用的协议.
     *
     * @return string
     */
    protected function getWorkerScheme(): string
    {
        return 'tcp';
    }

    /**
     * 向客户端发送消息.
     *
     * @param int    $fd
     * @param string $data
     *
     * @return bool
     */
    public function send(int $fd, string $data): bool
    {
        /** @var TcpConnection $connection */
        $connection = $this->worker->connections[$fd] ?? null;
        if (!$connection)
        {
            throw new \RuntimeException(sprintf('Connection %s does not exists', $fd));
        }

        return false !== $connection->send($data);
    }
}
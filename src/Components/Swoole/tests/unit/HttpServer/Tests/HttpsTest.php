<?php

declare(strict_types=1);

namespace Imi\Swoole\Test\HttpServer\Tests;

use Yurun\Util\HttpRequest;

/**
 * @testdox Https
 */
class HttpsTest extends BaseTest
{
    /**
     * @param string|null $name
     * @param array       $data
     * @param string      $dataName
     */
    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->host = imiGetEnv('HTTP_HTTPS_TEST_SERVER_HOST', 'https://127.0.0.1:13006/');
    }

    /**
     * 测试 Uri 地址
     *
     * @return void
     */
    public function testUri()
    {
        $http = new HttpRequest();
        $uri = $this->host . 'info?get=1';
        $response = $http->get($uri);
        $data = $response->json(true);
        $this->assertEquals($uri, $data['uri'] ?? null);
    }
}
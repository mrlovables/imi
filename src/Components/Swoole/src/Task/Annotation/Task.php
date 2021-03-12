<?php

declare(strict_types=1);

namespace Imi\Swoole\Task\Annotation;

use Imi\Bean\Annotation\Base;
use Imi\Bean\Annotation\Parser;
use Imi\Swoole\Task\TaskParam;

/**
 * 任务注解.
 *
 * @Annotation
 * @Target("CLASS")
 * @Parser("Imi\Swoole\Task\Parser\TaskParser")
 */
#[\Attribute]
class Task extends Base
{
    /**
     * 只传一个参数时的参数名.
     *
     * @var string|null
     */
    protected ?string $defaultFieldName = 'name';

    /**
     * 任务名称.
     *
     * @var string
     */
    public string $name = '';

    /**
     * 参数类.
     *
     * @var string
     */
    public string $paramClass = TaskParam::class;

    public function __construct(?array $__data = null, string $name = '', string $paramClass = TaskParam::class)
    {
        parent::__construct(...\func_get_args());
    }
}
<?php

declare(strict_types=1);

namespace Cms\Backend\Common\Doctrine\DBAL\Logging;

use Doctrine\DBAL\Logging\SQLLogger;

class QueryCountLogger implements SQLLogger
{
    /**
     * @var int
     */
    private static $count = 0;

    public function startQuery($sql, ?array $params = null, ?array $types = null): void
    {
    }

    public function stopQuery(): void
    {
        if (self::$count < PHP_INT_MAX) {
            self::$count++;
        }
    }

    public function getCount(): int
    {
        return self::$count;
    }
}

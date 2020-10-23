<?php

declare(strict_types=1);

namespace Cms\Backend\Common\Utils;

use Sentry\FlushableClientInterface;
use Sentry\SentrySdk;
use Sentry\State\Scope;

trait SentryFlushTrait
{
    protected function flushSentry(): void
    {
        $hub = SentrySdk::getCurrentHub();

        $client = $hub->getClient();
        if ($client instanceof FlushableClientInterface) {
            // required for daemon script
            $client->flush();
        }

        $hub->configureScope(static function (Scope $scope): void {
            $scope->clear();
        });
    }
}

<?php

declare(strict_types=1);

namespace Cms\Backend\Common\Doctrine\ORM;

interface EntityManagerCleanerInterface
{
    public function clearEntityManager(): void;
}

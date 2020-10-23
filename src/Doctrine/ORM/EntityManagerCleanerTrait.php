<?php

declare(strict_types=1);

namespace Cms\Backend\Common\Doctrine\ORM;

use Doctrine\ORM\EntityManagerInterface;

trait EntityManagerCleanerTrait
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    public function clearEntityManager(): void
    {
        $this->entityManager->clear();
    }
}

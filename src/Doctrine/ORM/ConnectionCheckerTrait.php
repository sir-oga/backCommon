<?php

declare(strict_types=1);

namespace Cms\Backend\Common\Doctrine\ORM;

use Doctrine\ORM\EntityManagerInterface;

trait ConnectionCheckerTrait
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    public function checkDbConnection(): void
    {
        if (false == $this->entityManager->getConnection()->ping()) {
            $this->entityManager->getConnection()->close();
            $this->entityManager->getConnection()->connect();
        }
    }

    public function checkEntityManagerConnection(): void
    {
        if (false == $this->entityManager->isOpen()) {
            /** @phpstan-ignore-next-line */
            $this->entityManager = $this->entityManager->create(
                $this->entityManager->getConnection(),
                $this->entityManager->getConfiguration(),
                $this->entityManager->getEventManager()
            );
        }
    }
}

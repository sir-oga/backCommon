<?php

declare(strict_types=1);

namespace Cms\Backend\Common\Doctrine\ORM\EntityManager;

use Cms\Backend\Common\Utils\Uuid;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Id\AbstractIdGenerator;

class UuidGenerator extends AbstractIdGenerator
{
    public function generate(EntityManager $em, $entity): string
    {
        return Uuid::generateUuid()->toHex();
    }
}

<?php

declare(strict_types=1);

namespace Cms\Backend\Common\Doctrine\ORM\Tools\Pagination;

use Cms\Backend\Common\Helper\ErrorHelper;
use Cms\Backend\Common\DTO\PageDTO;
use Cms\Backend\Common\Exception\DataValidationException;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Response;

class CustomPaginator extends Paginator
{
    public const MAX_LIMIT = 50;
    public const MAX_LIMIT_ADMIN = 10;

    /**
     * @var Paginator<mixed>
     */
    private $paginator;

    /**
     * @var int
     */
    private $limit = self::MAX_LIMIT;

    /**
     * @var int
     */
    private $offset = 0;

    public function __construct($query, $fetchJoinCollection = true, ?bool $useOutputWalkers = null)
    {
        $this->paginator = new Paginator($query, $fetchJoinCollection);
        $this->paginator->setUseOutputWalkers($useOutputWalkers);
    }

    public function countResults(): int
    {
        return $this->paginator->count();
    }

    /**
     * @param PageDTO $page
     * @return \Traversable<mixed>
     * @throws DataValidationException
     */
    public function getCurrentOffsetResults(PageDTO $page): \Traversable
    {
        $this->processParams($page);
        $this->paginator
            ->getQuery()
            ->setFirstResult($this->getOffset())
            ->setMaxResults($this->getLimit());

        return $this->paginator->getIterator();
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    private function processParams(PageDTO $page): void
    {
        if ($page->getLimit() > self::MAX_LIMIT) {
            throw new DataValidationException(
                ErrorHelper::MESSAGE_VALIDATION_ERROR,
                ErrorHelper::getCustomErrors('limit', sprintf('Maximum limit is %d', self::MAX_LIMIT)),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        if (!empty($page->getLimit())) {
            $this->limit = $page->getLimit();
        }

        $this->offset = $page->getOffset();
    }
}

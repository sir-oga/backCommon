<?php

declare(strict_types=1);

namespace Cms\Backend\Common\DTO\Input;

use Cms\Backend\Common\Doctrine\ORM\Tools\Pagination\CustomPaginator;
use Symfony\Component\Validator\Constraints as Assert;

trait ListDTOTrait
{
    /**
     * @Assert\Type("digit", groups={"read"})
     * @Assert\GreaterThanOrEqual(value=0, groups={"read"})
     *
     * @var int|null
     */
    public $limit;

    /**
     * @Assert\Type("digit", groups={"read"})
     * @Assert\GreaterThanOrEqual(value=0, groups={"read"})
     *
     * @var int|null
     */
    public $offset;

    public function getLimit(): int
    {
        return \ctype_digit($this->limit) ? (int) $this->limit : CustomPaginator::MAX_LIMIT;
    }

    public function getOffset(): int
    {
        return \ctype_digit($this->offset) ? (int) $this->offset : 0;
    }
}

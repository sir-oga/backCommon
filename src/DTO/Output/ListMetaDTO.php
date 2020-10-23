<?php

declare(strict_types=1);

namespace Cms\Backend\Common\DTO\Output;

use JsonSerializable;
use Swagger\Annotations as SWG;

/**
 * @SWG\Definition(required={"count", "offset", "limit"}, type="object")
 */
class ListMetaDTO implements JsonSerializable
{
    /**
     * @SWG\Property(
     *     description="Items count",
     *     type="integer"
     * )
     * @var int
     */
    private $count;

    /**
     * @SWG\Property(
     *     description="Items offset for current request",
     *     type="integer"
     * )
     * @var int
     */
    private $offset;

    /**
     * @SWG\Property(
     *     description="Items limit for current request",
     *     type="integer"
     * )
     * @var int
     */
    private $limit;

    public function __construct(int $count, int $offset, int $limit)
    {
        $this->count = $count;
        $this->offset = $offset;
        $this->limit = $limit;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @return array<mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'count' => $this->count,
            'offset' => $this->offset,
            'limit' => $this->limit,
        ];
    }
}

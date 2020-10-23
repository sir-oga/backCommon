<?php

declare(strict_types=1);

namespace Cms\Backend\Common\Collection;

use Cms\Backend\Common\Utils\Uuid;

/**
 * @implements \IteratorAggregate<Uuid>
 */
class UuidCollection implements \IteratorAggregate, \Countable
{
    /**
     * @var Uuid[]
     */
    private $items = [];

    /**
     * @param Uuid[] $items
     */
    public function __construct(iterable $items = [])
    {
        foreach ($items as $item) {
            $this->add($item);
        }
    }

    public function add(Uuid $item): void
    {
        $this->items[] = $item;
    }

    /**
     * @return \Traversable|Uuid[]
     */
    public function getIterator(): \Traversable
    {
        yield from $this->items;
    }

    public function count(): int
    {
        return count($this->items);
    }

    /**
     * @return string[]
     */
    public function toBin(): array
    {
        $result = [];
        foreach ($this->items as $item) {
            $result[] = $item->toBin();
        }

        return $result;
    }

    /**
     * @return string[]
     */
    public function toHex(): array
    {
        $result = [];
        foreach ($this->items as $item) {
            $result[] = $item->toHex();
        }
        
        return $result;
    }
}

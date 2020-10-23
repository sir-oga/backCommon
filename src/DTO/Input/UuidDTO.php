<?php

declare(strict_types=1);

namespace Cms\Backend\Common\DTO\Input;

use Cms\Backend\Common\Utils\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

class UuidDTO
{
    /**
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Uuid(strict=false)
     *
     * @var string
     */
    private $uuid;

    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getNewUuid(): Uuid
    {
        return new Uuid($this->uuid);
    }
}

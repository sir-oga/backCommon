<?php

declare(strict_types=1);

namespace Cms\Backend\Common\Utils;

use InvalidArgumentException;

class Uuid
{
    public const DEFAULT_STRING_VALUE = '00000000000000000000000000000000';

    /**
     * @var string
     */
    private $uuid;

    /**
     * Uuid constructor.
     *
     * @param string $uuid
     *
     * @throws InvalidArgumentException
     */
    public function __construct(string $uuid)
    {
        // Special check for dashes
        if (strlen($uuid) === 36) {
            $uuid = str_replace('-', '', $uuid);
        }

        // Convert binary value
        if (strlen($uuid) === 16) {
            $uuid = bin2hex($uuid);
        }

        if (self::isValid($uuid) === false) {
            throw new InvalidArgumentException("Invalid UUID '{$uuid}'");
        }

        $this->uuid = strtolower($uuid);
    }

    public function toHex(): string
    {
        return $this->uuid;
    }

    public function toBin(): string
    {
        $bin = hex2bin($this->uuid);
        if ($bin === false) {
            throw new InvalidArgumentException("Invalid UUID '{$this->uuid}'");
        }

        return $bin;
    }

    public function isEquals(Uuid $uuid): bool
    {
        return $this->toHex() === $uuid->toHex();
    }

    public function __toString(): string
    {
        return $this->toHex();
    }

    public static function isValid(string $uuid): bool
    {
        return (strlen($uuid) === 32 && ctype_xdigit($uuid) === true);
    }

    public static function fromHex(string $hex32): Uuid
    {
        return new self($hex32);
    }

    public static function fromBin(string $bin16): Uuid
    {
        return new self($bin16);
    }

    public static function generateUuid(): Uuid
    {
        try {
            return new self(random_bytes(16));
        } catch (\Exception $ex) {
            throw new \RuntimeException($ex->getMessage(), $ex->getCode(), $ex);
        }
    }
}

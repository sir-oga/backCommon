<?php

declare(strict_types=1);

namespace Cms\Backend\Common\Doctrine\DBAL\Types;

use Cms\Backend\Common\Utils\Uuid as UuidUtil;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class Uuid extends Type
{
    private const NAME = 'binary';
    private const LENGTH = 16;

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return $platform->getBinaryTypeDeclarationSQL(['length' => self::LENGTH, 'fixed' => true]);
    }

    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @param null|string $value
     * @param AbstractPlatform $platform
     *
     * @return null|UuidUtil
     */
    public function convertToPhpValue($value, AbstractPlatform $platform): ?UuidUtil
    {
        if ($value !== null) {
            return new UuidUtil($value);
        }

        return $value;
    }

    /**
     * @param UuidUtil|string|mixed $value
     * @param AbstractPlatform $platform
     *
     * @return mixed
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (is_string($value)) {
            $value = new UuidUtil($value);
        }

        if ($value instanceof UuidUtil) {
            return $value->toBin();
        }

        return $value;
    }
}

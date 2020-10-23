<?php

declare(strict_types=1);

namespace Cms\Backend\Common\Tests\Unit\Helper;

use Cms\Backend\Common\Utils\Uuid;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class UuidTest extends TestCase
{
    /**
     * @return array<array>
     */
    public function getNotValidUuidProvider(): array
    {
        return [
            ['m50d5dae191c83500a00c94752f43cd8'],
            ['m50d5dae191c83500a00c94752f43cd812f'],
            ['m50d5dae191c83500a00c94752f43c'],
            [''],
        ];
    }

    /**
     * @dataProvider getNotValidUuidProvider
     *
     * @param string $uuid
     */
    public function testUuidGenerateNotValid(
        string $uuid
    ): void {
        $this->expectExceptionMessage("Invalid UUID '{$uuid}'");
        $this->expectException(InvalidArgumentException::class);
        new Uuid($uuid);
    }

    public function testUuidToHex(): void
    {
        $uuidHex = 'f50d5dae191c83500a00c94752f43cd8';
        $uuid = new Uuid($uuidHex);
        self::assertSame($uuidHex, $uuid->toHex());
    }

    public function testUuidToBin(): void
    {
        $uuidHex = 'f50d5dae191c83500a00c94752f43cd8';
        $uuid = new Uuid($uuidHex);
        self::assertSame(hex2bin($uuidHex), $uuid->toBin());
    }

    public function testUuidIsEquals(): void
    {
        $uuidHex1 = 'f50d5dae191c83500a00c94752f43cd8';
        $uuidHex2 = 'df1d5dae191c83500a00c94752f43cd8';
        $uuid1 = new Uuid($uuidHex1);
        $uuid2 = new Uuid($uuidHex2);
        self::assertTrue($uuid1->isEquals($uuid1));
        self::assertNotTrue($uuid2->isEquals($uuid1));
    }

    /**
     * @return array<array>
     */
    public function getUuidProvider(): array
    {
        return [
            ['m50d5dae191c83500a00c94752f43cd8', false],
            ['m50d5dae191c83500a00c94752f43cd812f', false],
            ['m50d5dae191c83500a00c94752f43c', false],
            ['', false],
            ['f50d5dae191c83500a00c94752f43cd8', true],
        ];
    }

    /**
     * @dataProvider getUuidProvider
     *
     * @param string $uuid
     * @param bool $expectedResult
     */
    public function testIsValid(
        string $uuid,
        bool $expectedResult
    ): void {
        self::assertSame(Uuid::isValid($uuid), $expectedResult);
    }

    public function testUuidFromHex(): void
    {
        $uuidHex = 'f50d5dae191c83500a00c94752f43cd8';
        $uuid = new Uuid($uuidHex);
        self::assertTrue($uuid->isEquals(Uuid::fromHex($uuidHex)));
    }

    public function testUuidFromBin(): void
    {
        $uuidHex = 'f50d5dae191c83500a00c94752f43cd8';
        $uuid = new Uuid($uuidHex);
        $uuidBin = $uuid->toBin();
        self::assertTrue($uuid->isEquals(Uuid::fromBin($uuidBin)));
    }

    public function testUuidGenerate(): void
    {
        self::assertTrue(Uuid::isValid(Uuid::generateUuid()->toHex()));
    }
}

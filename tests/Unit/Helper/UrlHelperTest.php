<?php

declare(strict_types=1);

namespace Cms\Backend\Common\Tests\Unit\Helper;

use Cms\Backend\Common\Helper\UrlHelper;
use PHPUnit\Framework\TestCase;

class UrlHelperTest extends TestCase
{
    /**
     * @return array<array>
     */
    public function getHostDataProvider(): array
    {
        return [
            ['', null],
            ['http://google.com', 'google.com'],
            ['http://google.com?utm_content=777', 'google.com'],
            ['invalid.host', null],
            ['string', null],
        ];
    }

    /**
     * @dataProvider getHostDataProvider
     *
     * @param string $urlSource
     * @param string|null $expectedResult
     */
    public function testGetHost(
        string $urlSource,
        ?string $expectedResult
    ): void {
        $helper = new UrlHelper();
        self::assertSame($expectedResult, $helper->getHost($urlSource));
    }

    /**
     * @return array<array>
     */
    public function getQueryParamsDataProvider(): array
    {
        return [
            ['', []],
            ['http://google.com', []],
            ['http://google.com?foo=bar', ['foo' => 'bar']],
            ['http://google.com?foo=&bar=#baz', ['foo' => '', 'bar' => '']],
            ['invalid.host', []],
            ['string', []],
        ];
    }

    /**
     * @dataProvider getQueryParamsDataProvider
     *
     * @param string $urlSource
     * @param array<array> $expectedResult
     */
    public function testGetQueryParams(
        string $urlSource,
        array $expectedResult
    ): void {
        $helper = new UrlHelper();
        self::assertSame($expectedResult, $helper->getQueryParams($urlSource));
    }

    /**
     * @return array<array>
     */
    public function getQueryParamDataProvider(): array
    {
        return [
            ['http://google.com?foo=bar', 'foo', 'bar'],
            ['http://google.com?foo=&bar=#baz', 'foo', ''],
            ['http://google.com?foo=&bar=#baz', 'another', null],
        ];
    }

    /**
     * @dataProvider getQueryParamDataProvider
     *
     * @param string $urlSource
     * @param string $param
     * @param string|null $expectedResult
     */
    public function testGetQueryParam(
        string $urlSource,
        string $param,
        ?string $expectedResult
    ): void {
        $helper = new UrlHelper();
        self::assertSame($expectedResult, $helper->getQueryParam($urlSource, $param));
    }
}

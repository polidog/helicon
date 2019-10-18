<?php

declare(strict_types=1);

namespace Polidog\Helicon\Converter;

use PHPUnit\Framework\TestCase;

class ScalarTypeConverterTest extends TestCase
{
    /**
     * @dataProvider dpSupportedTypes
     *
     * @param string $type
     */
    public function testSupports(string $type): void
    {
        $converter = new ScalarTypeConverter();
        $this->assertTrue($converter->supports($type));
    }

    /**
     * @dataProvider dpConvertData
     *
     * @param $value
     * @param string $type
     * @param $expect
     */
    public function testConvert($value, string $type, $expect): void
    {
        $converter = new ScalarTypeConverter();
        $actual = $converter->convert($value, $type);
        $this->assertSame($expect, $actual);
    }

    public function dpSupportedTypes(): array
    {
        return [
            ['string'],
            ['bool'],
            ['boolean'],
            ['int'],
            ['integer'],
            ['float'],
            ['double'],
        ];
    }

    public function dpConvertData(): array
    {
        return [
            [
                1,
                'string',
                '1',
            ],
            [
                true,
                'string',
                '1',
            ],
            [
                '0.3',
                'float',
                0.3,
            ],
        ];
    }
}

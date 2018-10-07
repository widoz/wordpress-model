<?php # -*- coding: utf-8 -*-

use WordPressModel\Tests\Unit\Utils;

use \Brain\Monkey\Functions;
use WordPressModel\Tests\TestCase;
use WordPressModel\Utils\ImplodeArray;

class ImplodeArrayTest extends TestCase
{
    public function testInstance()
    {
        $sut = new ImplodeArray([]);

        self::assertInstanceOf(ImplodeArray::class, $sut);
    }

    public function testForAttributeStyle()
    {
        Functions\expect('wp_is_numeric_array')
            ->once()
            ->andReturn(false);

        $sut = new ImplodeArray([
            'key' => 'value',
            'key2' => 'value2'
        ]);

        $string = $sut->forAttributeStyle();

        self::assertSame('key:value;key2:value2', $string);
    }
}

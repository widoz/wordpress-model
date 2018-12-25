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
        $sut = new ImplodeArray([
            'key' => 'value',
            'key2' => 'value2',
        ]);

        $string = $sut->forAttributeStyle();

        self::assertSame('key:value;key2:value2', $string);
    }

    public function testForAttributeStyleProduceEmptyStringIfArrayIsNotAssociative()
    {
        $sut = new ImplodeArray([
            'value',
            'value2',
        ]);

        $string = $sut->forAttributeStyle();

        self::assertSame('', $string);
    }

    public function testForAttributeStyleProduceEmptyStringIfArrayIsAssociativeButUseNumbers()
    {
        $sut = new ImplodeArray([
            '1' => 'value',
            '2' => 'value2',
        ]);

        $string = $sut->forAttributeStyle();

        self::assertSame('', $string);
    }
}

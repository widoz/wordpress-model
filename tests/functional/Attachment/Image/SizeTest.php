<?php # -*- coding: utf-8 -*-
// phpcs:disable

namespace WordPressModel\Tests\Functional\Attachment\Image;

use WordPressModel\Attachment\Image\Size as Testee;
use ProjectTestsHelper\Phpunit\TestCase;

class SizeTest extends TestCase
{
    public function testInstanceByString()
    {
        $testee = new Testee('attachment-size');

        self::assertInstanceOf(Testee::class, $testee);
    }

    public function testInstanceByValues()
    {
        $testee = new Testee(100, 100);

        self::assertInstanceOf(Testee::class, $testee);
    }

    public function testStringValue()
    {
        $testee = new Testee('attachment-size');

        $value = $testee->value();

        self::assertSame('attachment-size', $value);
    }

    /**
     * @dataProvider numericValues
     */
    public function testIntegerValues(array $values, array $expected)
    {
        $testee = new Testee(...$values);

        $value = $testee->value();

        self::assertSame($expected, $value);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testThrowInvalidArgumentExceptionIfSizesIsEmpty()
    {
        $testee = new Testee();

        $testee->value();
    }

    /**
     * @expectedException \LengthException
     */
    public function testThrowInvalidArgumentExceptionIfSizesCountGreaterThan2()
    {
        $testee = new Testee(1, 2, 3);

        $testee->value();
    }

    /**
     * @expectedException \DomainException
     */
    public function testThrowInvalidArgumentExceptionIfSizesIsArrayButItemsAreNotNumerics()
    {
        $testee = new Testee('item', 'item');

        $testee->value();
    }

    /**
     * Numeric Data provider
     *
     * @return array
     */
    public function numericValues()
    {
        return [
            [
                [150, 100],
                [150, 100]
            ],
            [
                ['150', '100'],
                [150, 100]
            ],
        ];
    }
}

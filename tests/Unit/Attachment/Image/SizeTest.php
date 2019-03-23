<?php # -*- coding: utf-8 -*-

/*
 * This file is part of the WordPress Model package.
 *
 * (c) Guido Scialfa <dev@guidoscialfa.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace WordPressModel\Attachment\Image;

use Brain\Monkey\Functions;
use ProjectTestsHelper\Phpunit\TestCase;
use InvalidArgumentException;
use WordPressModel\Attachment\Image\Size as Testee;

/**
 * Class SizeTest
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class SizeTest extends TestCase
{
    /**
     * Test Create Size by Name
     *
     * @throws \InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \UnexpectedValueException
     */
    public function testCreateBySizeName(): void
    {
        Functions\expect('get_intermediate_image_sizes')
            ->andReturn([
                'image_size',
                'additional_image_size',
            ]);

        Functions\expect('wp_get_additional_image_sizes')
            ->andReturn([
                'additional_image_size' => [
                    'width' => 1,
                    'height' => 1,
                    'crop' => true,
                ],
            ]);

        Functions\expect('get_option')
            ->twice()
            ->andReturn(2);

        $testee = Testee::createBySizeName('additional_image_size');
        self::assertSame(1, $testee->width());
        self::assertSame(1, $testee->height());

        $testee = Testee::createBySizeName('image_size');
        self::assertSame(2, $testee->width());
        self::assertSame(2, $testee->height());
    }

    /**
     * Test Create Size by Name Throw Exception if Name is not a Valid item in the List
     * of the Registered sizes.
     *
     * @throws InvalidArgumentException
     */
    public function testCreateBySizeNameThrowInvalidArgumentException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'additional_image_size_that_not_exists size not found on WordPress registered sizes.'
        );

        Functions\expect('get_intermediate_image_sizes')
            ->andReturn([
                'image_size',
                'additional_image_size',
            ]);

        Functions\expect('wp_get_additional_image_sizes')
            ->andReturn([
                'additional_image_size' => [
                    'width' => 1,
                    'height' => 1,
                    'crop' => true,
                ],
            ]);

        Testee::createBySizeName('additional_image_size_that_not_exists');
    }

    /**
     * Test Create by Values
     *
     * @throws InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testCreateByValues(): void
    {
        $testee = Testee::createByValues(1, 1);

        self::assertSame(1, $testee->width());
        self::assertSame(1, $testee->height());
    }

    /**
     * Test Create by Values Throw Exception if Given Width and Height are Less or Equal than Zero
     *
     * @throws InvalidArgumentException
     */
    public function testCreateByValuesThrowInvalidArgumentException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Width and Height must be greater than zero');

        Testee::createByValues(0, 0);
    }
}

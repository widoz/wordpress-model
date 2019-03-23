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

namespace WordPressModel\Utils;

use ProjectTestsHelper\Phpunit\TestCase;
use WordPressModel\Utils\Assert as Testee;
use InvalidArgumentException;

/**
 * Class AssertTest
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class AssertTest extends TestCase
{
    /**
     * Test Array Contains Only Strings
     *
     * @throws InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testIsStringValueMap(): void
    {
        Testee::isStringValueMap(['key_1' => 'value_1']);

        self::assertTrue(true);
    }

    /**
     * Test Array Throw Exception Because Given Array Does not Contains Only Strings
     *
     * @throws InvalidArgumentException
     */
    public function testInvalidStringValueMap(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Expect map of strings - All values of map are strings.');

        Testee::isStringValueMap(['key_1' => 1]);
    }

    /**
     * Test Array Contains Given Element
     *
     * @throws InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testArrayContains(): void
    {
        Testee::arrayContains('element', ['element']);

        self::assertTrue(true);
    }

    /**
     * Test ArrayContains Assertion Throw Exception
     *
     * @throws InvalidArgumentException
     */
    public function testInvalidArrayContains(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Expect item in array.');

        Testee::arrayContains('element', ['item']);
    }
}

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

/**
 * Class AssertTest
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class AssertTest extends TestCase
{
    /**
     * @throws \InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testIsStringValueMap(): void
    {
        Testee::isStringValueMap(['key_1' => 'value_1']);

        self::assertTrue(true);
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function testInvalidStringValueMap(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Testee::isStringValueMap(['key_1' => 1]);
    }
}

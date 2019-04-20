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

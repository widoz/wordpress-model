<?php # -*- coding: utf-8 -*-

/*
 * This file is part of the WordPress Theme Model Theme package.
 *
 * (c) Guido Scialfa <dev@guidoscialfa.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WordPressModel\Tests\Unit\Model;

use Brain\Monkey\Functions;
use WordPressModel\Brand;
use WordPressModel\Tests\TestCase;

class BrandTest extends TestCase
{
    public function testNoBlogNameReturnEmptyData()
    {
        Functions\expect('get_bloginfo')
            ->once()
            ->andReturn('');

        $sut = new Brand('post-thumbnail');
        $response = $sut->data();

        self::assertEmpty($response);
    }
}

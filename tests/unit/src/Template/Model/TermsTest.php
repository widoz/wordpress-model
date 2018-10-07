<?php # -*- coding: utf-8 -*-

/*
 * This file is part of the WordPress Theme Model Theme package.
 *
 * (c) Guido Scialfa <dev@guidoscialfa.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WordPressModel\Tests\Unit\Template\Model;

use \Brain\Monkey\Functions;
use \Brain\Monkey\Filters;
use WordPressModel\Terms;
use WordPressModel\Tests\TestCase;

class TermsTest extends TestCase
{
    public function testEmptyTermsReturnEmptyData()
    {
        Functions\expect('get_terms')
            ->once()
            ->andReturn([]);

        Functions\when('is_wp_error')
            ->justReturn(false);

        $sut = new Terms('category');
        $response = $sut->data();

        self::assertEmpty($response);
    }

    public function testIntTermsValueReturnEmptyData()
    {
        Functions\expect('get_terms')
            ->once()
            ->andReturn(2);

        Functions\when('is_wp_error')
            ->justReturn(false);

        $sut = new Terms('category');
        $response = $sut->data();

        self::assertEmpty($response);
    }

    public function testWpErrorReturnEmptyData()
    {
        Functions\expect('get_terms')
            ->once()
            ->andReturn(['empty but contains value']);

        Functions\when('is_wp_error')
            ->justReturn(true);

        $sut = new Terms('category');
        $response = $sut->data();

        self::assertEmpty($response);
    }

    public function testCustomFilterIsApplied()
    {
        Functions\expect('get_terms')
            ->once()
            ->andReturn([]);

        Functions\when('is_wp_error')
            ->justReturn(false);

        $sut = new Terms('category', 'custom_filter');
        $sut->data();

        self::assertTrue(Filters\applied('custom_filter') > 0);
    }
}

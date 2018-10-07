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
use WordPressModel\MainNavMenu;
use WordPressModel\Tests\TestCase;

class MainNavMenuTest extends TestCase
{
    public function testEmpyDataIsReturnedIfLocationDoesntHaveMenu()
    {
        Functions\expect('has_nav_menu')
            ->andReturn(false);

        $sut = new MainNavMenu('location');
        $response = $sut->data();

        self::assertEmpty($response);
    }
}

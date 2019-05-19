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

namespace WordPressModel\Tests\Unit;

use Brain\Monkey;
use ProjectTestsHelper\Phpunit\TestCase;
use WordPressModel\DescriptionFactory as Testee;

class DescriptionTest extends TestCase
{
    public function testInstance()
    {
        $testee = new Testee();

        self::assertInstanceOf(Testee::class, $testee);
    }

    public function testForHome()
    {
        $post = $this
            ->getMockBuilder('WP_Post')
            ->getMock();
        $post->post_excerpt = 'post_excerpt';

        $testee = new Testee();

        Monkey\Functions\expect('get_option')
            ->once()
            ->with('page_for_posts', 0)
            ->andReturn(1);

        Monkey\Functions\expect('get_post')
            ->once()
            ->with(1)
            ->andReturn($post);

        Monkey\Filters\expectApplied(Testee::FILTER_HOME_DESCRIPTION)
            ->once()
            ->with('post_excerpt');

        $testee->forHome();

        self::assertTrue(true);
    }

    public function testForArchive()
    {
        $testee = new Testee();

        Monkey\Functions\expect('get_the_archive_description')
            ->once()
            ->andReturn('');

        $testee->forArchive();

        self::assertTrue(true);
    }
}

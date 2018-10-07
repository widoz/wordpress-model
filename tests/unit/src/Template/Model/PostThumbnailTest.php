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

use \Brain\Monkey\Functions;
use WordPressModel\PostThumbnail;
use WordPressModel\Tests\TestCase;

class PostThumbnailTest extends TestCase
{
    public function testThemeDoesnotSupportThumbnailReturnEmptyData()
    {
        $postMock = \Mockery::mock('WP_Post');

        Functions\expect('current_theme_supports')
            ->once()
            ->with('post-thumbnails')
            ->andReturn(false);

        $sut = new PostThumbnail($postMock);

        $response = $sut->data();

        self::assertEmpty($response);
    }

    public function testPostThatNotHasThumbnailReturnEmptyData()
    {
        $postMock = \Mockery::mock('WP_Post');

        Functions\expect('current_theme_supports')
            ->once()
            ->with('post-thumbnails')
            ->andReturn(true);

        Functions\expect('has_post_thumbnail')
            ->once()
            ->with($postMock)
            ->andReturn(false);

        $sut = new PostThumbnail($postMock);

        $response = $sut->data();

        self::assertEmpty($response);
    }
}

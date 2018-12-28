<?php # -*- coding: utf-8 -*-

/*
 * This file is part of the WordPress Theme Model package.
 *
 * (c) Guido Scialfa <dev@guidoscialfa.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WordPressModel\Tests\Unit\Model;

use \Brain\Monkey\Functions;
use WordPressModel\Model\FigureAttachmentImage;
use WordPressModel\Model\PostThumbnail;
use WordPressModel\Tests\TestCase;

class PostThumbnailTest extends TestCase
{
    public function testPostThumbnailData()
    {
        $postMock = \Mockery::mock('WP_Post');
        $postMock->ID = 1;

        $figureAttachmentMock = \Mockery::mock('overload:' . FigureAttachmentImage::class);
        $figureAttachmentMock
            ->shouldReceive('data')
            ->andReturn([]);

        Functions\expect('current_theme_supports')
            ->once()
            ->with('post-thumbnails')
            ->andReturn(true);

        Functions\expect('has_post_thumbnail')
            ->once()
            ->with($postMock)
            ->andReturn(true);

        Functions\expect('get_permalink')
            ->once()
            ->with($postMock)
            ->andReturn('permalink');

        Functions\expect('get_post_thumbnail_id')
            ->once()
            ->andReturn(2);

        $sut = new PostThumbnail($postMock, 'post-thumbnail');

        $response = $sut->data();

        self::assertEquals([
            'link' => [
                'attributes' => [
                    'href' => 'permalink',
                ],
            ],
        ], $response);
    }

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

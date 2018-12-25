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
use WordPressModel\PostTitle;
use WordPressModel\Tests\TestCase;

class PostTitleTest extends TestCase
{
    public function testLinkIsntSetIfQueryIsForSingularPost()
    {
        $postMock = \Mockery::mock('\WP_Post');

        $queryMock = \Mockery::mock('\WP_Query');
        $queryMock
            ->shouldReceive('is_singular')
            ->once()
            ->andReturn(true);

        Functions\expect('get_permalink')
            ->never();

        Functions\expect('get_the_title')
            ->once()
            ->with($postMock)
            ->andReturn('Post Title');

        $sut = new PostTitle($postMock, $queryMock);
        $data = $sut->data();

        self::assertEmpty($data['link']['attributes']['href']);
    }

    public function testLinkIsntSetIfPermalinkIsntValid()
    {
        $postMock = \Mockery::mock('\WP_Post');

        $queryMock = \Mockery::mock('\WP_Query');
        $queryMock
            ->shouldReceive('is_singular')
            ->once()
            ->andReturn(false);

        Functions\expect('get_permalink')
            ->once()
            ->with($postMock)
            ->andReturn(false);

        Functions\expect('get_the_title')
            ->once()
            ->with($postMock)
            ->andReturn('Post Title');

        $sut = new PostTitle($postMock, $queryMock);
        $data = $sut->data();

        self::assertEmpty($data['link']['attributes']['href']);
    }
}

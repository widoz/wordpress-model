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

use WordPressModel\CommentSectionTitle;
use PHPUnit\Framework\TestCase;
use \Brain\Monkey\Functions;

class CommentSectionTitleDataTest extends TestCase
{
    public function testTitleWithOneCommentAndTitleSet()
    {
        Functions\when('in_the_loop')
            ->justReturn(true);

        Functions\when('apply_filters')
            ->returnArg(2);

        Functions\when('esc_html')
            ->returnArg(1);

        Functions\when('_n')
            ->returnArg(1);

        Functions\expect('get_the_title')
            ->once()
            ->andReturn('Title');

        Functions\when('get_comments_number')
            ->justReturn(1);

        Functions\when('number_format_i18n')
            ->returnArg(1);

        $classAttributeMock = \Mockery::mock('WordPressModel\\Attribute\\Attribute');
        $bemMock = \Mockery::mock('WordPressModel\\Bem\\Bem');

        $classAttributeMock
            ->shouldReceive('value')
            ->once()
            ->with('comments__title')
            ->andReturn('comments__title');

        $classAttributeMock
            ->shouldReceive('value')
            ->once()
            ->with('comments-for')
            ->andReturn('comments-for');

        $sut = new CommentSectionTitle();

        $response = $sut->data();

        $this->assertSame(
            '%d response to <span class="{{ attributes.class.commentsForTitle }}">Title</span>',
            $response['title']
        );
    }

    public function testTitleWithOneCommentAndTitleEmpty()
    {
        Functions\when('in_the_loop')
            ->justReturn(true);

        Functions\when('apply_filters')
            ->returnArg(2);

        Functions\when('esc_html')
            ->returnArg(1);

        Functions\when('_n')
            ->returnArg(1);

        Functions\expect('get_the_title')
            ->once()
            ->andReturn('');

        Functions\when('get_comments_number')
            ->justReturn(1);

        Functions\when('number_format_i18n')
            ->returnArg(1);

        $classAttributeMock = \Mockery::mock('WordPressModel\\Attribute\\Attribute');
        $bemMock = \Mockery::mock('WordPressModel\\Bem\\Bem');

        $sut = new CommentSectionTitle();

        $response = $sut->data();

        $this->assertSame('%d response', $response['title']);
    }
}

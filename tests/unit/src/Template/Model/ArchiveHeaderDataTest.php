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

use WordPressModel\ArchiveHeader;
use WordPressModel\Tests\TestCase;
use \Brain\Monkey;

class ArchiveHeaderDataTest extends TestCase
{
    public function testArchiveTitleForPageForPosts()
    {
        Monkey\Functions\when('apply_filters')
            ->returnArg(2);

        Monkey\Functions\when('WordPressModel\\Functions\\stringToBool')
            ->justReturn(true);

        Monkey\Functions\when('get_the_archive_title')
            ->justReturn('');

        Monkey\Functions\expect('get_option')
            ->once()
            ->with('page_for_posts')
            ->andReturn(1);

        Monkey\Functions\expect('get_the_title')
            ->once()
            ->andReturn('Title: Page For Posts');

        Monkey\Functions\expect('is_home')
            ->andReturn(true);

        Monkey\Functions\expect('get_the_archive_description')
            ->never();

        $sut = new ArchiveHeader();
        $response = $sut->data();

        $this->assertSame('Title: Page For Posts', $response['title']['text']);
    }

    public function testThatIfPageForPostsShowEmptyArchiveDescription()
    {
        Monkey\Functions\when('apply_filters')
            ->returnArg(2);

        Monkey\Functions\when('WordPressModel\\Functions\\stringToBool')
            ->justReturn(true);

        Monkey\Functions\when('get_the_archive_title')
            ->justReturn('');

        Monkey\Functions\expect('is_home')
            ->andReturn(true);

        Monkey\Functions\expect('get_the_title')
            ->once()
            ->andReturn('Title: Page For Posts');

        Monkey\Functions\expect('get_option')
            ->once()
            ->with('page_for_posts')
            ->andReturn(1);

        Monkey\Functions\expect('get_the_archive_description')
            ->never();

        $sut = new ArchiveHeader();
        $response = $sut->data();

        $this->assertSame('', $response['description']['text']);
    }

    public function testThatTitleForPageForPostsFallbackToArchiveTitle()
    {
        Monkey\Functions\when('get_the_title')
            ->justReturn('Title: Page For Posts');

        Monkey\Functions\when('apply_filters')
            ->returnArg(2);

        Monkey\Functions\when('get_the_archive_description')
            ->justReturn('Archive Description');

        Monkey\Functions\when('WordPressModel\\Functions\\stringToBool')
            ->justReturn(true);

        Monkey\Functions\when('get_option')
            ->justReturn(1);

        Monkey\Functions\expect('is_home')
            ->andReturn(false);

        Monkey\Functions\expect('get_the_archive_title')
            ->once()
            ->andReturn('Title: Archive Title');

        $sut = new ArchiveHeader();
        $response = $sut->data();

        $this->assertSame('Title: Archive Title', $response['title']['text']);
    }

    public function testThatArchiveDescriptionIsShowedIfNotPageForPosts()
    {
        Monkey\Functions\when('get_the_title')
            ->justReturn('Title: Page For Posts');

        Monkey\Functions\when('apply_filters')
            ->returnArg(2);

        Monkey\Functions\when('WordPressModel\\Functions\\stringToBool')
            ->justReturn(true);

        Monkey\Functions\when('get_option')
            ->justReturn(1);

        Monkey\Functions\when('get_the_archive_title')
            ->justReturn('Title: Archive Title');

        Monkey\Functions\expect('is_home')
            ->andReturn(false);

        Monkey\Functions\expect('get_the_archive_description')
            ->once()
            ->andReturn('Archive Description');

        $sut = new ArchiveHeader();
        $response = $sut->data();

        $this->assertSame('Archive Description', $response['description']['text']);
    }
}

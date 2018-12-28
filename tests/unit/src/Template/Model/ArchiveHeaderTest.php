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

use WordPressModel\Model\ArchiveHeader;
use WordPressModel\Model\Title;
use WordPressModel\Model\Description;
use WordPressModel\Tests\TestCase;
use \Brain\Monkey;

class ArchiveHeaderTest extends TestCase
{
    public function testArchiveHeaderData()
    {
        $title = \Mockery::mock(Title::class);
        $description = \Mockery::mock(Description::class);
        $sut = new ArchiveHeader($title, $description);
        $expected = [
            'container' => [
                'attributes' => [
                    'class' => 'archive__header',
                ],
            ],
            'title' => [
                'text' => 'Title Archive',
                'attributes' => [
                    'class' => 'archive__title',
                ],
            ],
            'description' => [
                'text' => 'Description Archive',
                'attributes' => [
                    'class' => 'archive__description',
                ],
            ],
        ];

        Monkey\Functions\expect('is_home')
            ->once()
            ->andReturn(false);

        Monkey\Filters\expectApplied(ArchiveHeader::FILTER_DATA)
            ->once()
            ->with($expected);

        $title
            ->shouldReceive('forArchive')
            ->once()
            ->andReturn('Title Archive');

        $description
            ->shouldReceive('forArchive')
            ->once()
            ->andReturn('Description Archive');

        $response = $sut->data();

        self::assertSame($expected, $response);
    }

    public function testArchiveHeaderDataForPageForPosts()
    {
        $title = \Mockery::mock(Title::class);
        $description = \Mockery::mock(Description::class);
        $sut = new ArchiveHeader($title, $description);
        $expected = [
            'container' => [
                'attributes' => [
                    'class' => 'archive__header',
                ],
            ],
            'title' => [
                'text' => 'Title Page For Posts',
                'attributes' => [
                    'class' => 'archive__title',
                ],
            ],
            'description' => [
                'text' => 'Description Page For Posts',
                'attributes' => [
                    'class' => 'archive__description',
                ],
            ],
        ];

        Monkey\Functions\expect('is_home')
            ->once()
            ->andReturn(true);

        Monkey\Filters\expectApplied(ArchiveHeader::FILTER_DATA)
            ->once()
            ->with($expected);

        $title
            ->shouldReceive('forArchive')
            ->once()
            ->andReturn('Title Archive');

        $title
            ->shouldReceive('forHome')
            ->once()
            ->andReturn('Title Page For Posts');

        $description
            ->shouldReceive('forArchive')
            ->once()
            ->andReturn('Description Archive');

        $description
            ->shouldReceive('forHome')
            ->once()
            ->andReturn('Description Page For Posts');

        $response = $sut->data();

        self::assertSame($expected, $response);
    }
}

<?php # -*- coding: utf-8 -*-
// phpcs:disable

namespace WordPressModel\Tests\Unit\Model;

use WordPressModel\Model\ArchiveTitle;
use WordPressModel\Model\Title;
use Brain\Monkey;
use WordPressModel\Tests\TestCase;

class ArchiveTitleTest extends TestCase
{
    public function testsInstance()
    {
        $title = \Mockery::mock(Title::class);
        $sut = new ArchiveTitle($title);

        self::assertInstanceOf(ArchiveTitle::class, $sut);
    }

    public function testDescriptionForPageForPosts()
    {
        $title = \Mockery::mock(Title::class);
        $sut = new ArchiveTitle($title);

        Monkey\Functions\expect('is_home')
            ->once()
            ->andReturn(true);

        Monkey\Filters\expectApplied(ArchiveTitle::FILTER_DATA)
            ->once()
            ->with([
                'value' => 'Description for Page For Posts',
            ]);

        $title
            ->shouldReceive('forHome')
            ->once()
            ->andReturn('Description for Page For Posts');

        $response = $sut->data();

        self::assertSame(
            [
                'value' => 'Description for Page For Posts',
            ],
            $response
        );
    }

    public function testDescriptionForArchive()
    {
        $title = \Mockery::mock(Title::class);
        $sut = new ArchiveTitle($title);

        Monkey\Functions\expect('is_home')
            ->once()
            ->andReturn(false);

        Monkey\Filters\expectApplied(ArchiveTitle::FILTER_DATA)
            ->once()
            ->with([
                'value' => 'Description for Archive',
            ]);

        $title
            ->shouldReceive('forArchive')
            ->once()
            ->andReturn('Description for Archive');

        $response = $sut->data();

        self::assertSame(
            [
                'value' => 'Description for Archive',
            ],
            $response
        );
    }
}

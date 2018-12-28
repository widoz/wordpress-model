<?php # -*- coding: utf-8 -*-
// phpcs:disable

namespace WordPressModel\Tests\Unit\Model;

use WordPressModel\Model\ArchiveDescription;
use WordPressModel\Model\Description;
use Brain\Monkey;
use WordPressModel\Tests\TestCase;

class ArchiveDescriptionTest extends TestCase
{
    public function testsInstance()
    {
        $description = \Mockery::mock(Description::class);
        $sut = new ArchiveDescription($description);

        self::assertInstanceOf(ArchiveDescription::class, $sut);
    }

    public function testDescriptionForPageForPosts()
    {
        $description = \Mockery::mock(Description::class);
        $sut = new ArchiveDescription($description);

        Monkey\Functions\expect('is_home')
            ->once()
            ->andReturn(true);

        Monkey\Filters\expectApplied(ArchiveDescription::FILTER_DATA)
            ->once()
            ->with([
                'value' => 'Description for Page For Posts',
            ]);

        $description
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
        $description = \Mockery::mock(Description::class);
        $sut = new ArchiveDescription($description);

        Monkey\Functions\expect('is_home')
            ->once()
            ->andReturn(false);

        Monkey\Filters\expectApplied(ArchiveDescription::FILTER_DATA)
            ->once()
            ->with([
                'value' => 'Description for Archive',
            ]);

        $description
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

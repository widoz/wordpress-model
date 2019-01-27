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

use Widoz\Bem\Factory;
use Widoz\Bem\Service;
use WordPressModel\Model\ArchiveHeader as Testee;
use WordPressModel\Model\Title;
use WordPressModel\Model\Description;
use \Brain\Monkey;
use ProjectTestsHelper\Phpunit\TestCase;

class ArchiveHeaderTest extends TestCase
{
    public function testArchiveHeaderData()
    {
        $bem = $this->createMock(Service::class);
        $bemFactory = $this->createMock(Factory::class);
        $title = $this->createMock(Title::class);
        $description = $this->createMock(Description::class);
        $testee = new Testee($bemFactory, $title, $description);

        Monkey\Functions\expect('is_home')
            ->once()
            ->andReturn(false);

        Monkey\Filters\expectApplied(Testee::FILTER_DATA)
            ->once();

        $bemFactory
            ->expects($this->once())
            ->method('createService')
            ->willReturn($bem);

        $title
            ->expects($this->once())
            ->method('forArchive');

        $description
            ->expects($this->once())
            ->method('forArchive');

        $bem
            ->expects($this->exactly(2))
            ->method('forElement')
            ->withConsecutive(['title'], ['description']);

        $testee->data();

        self::assertTrue(true);
    }

    public function testArchiveHeaderDataForPageForPosts()
    {
        $bem = $this->createMock(Service::class);
        $bemFactory = $this->createMock(Factory::class);
        $title = $this->createMock(Title::class);
        $description = $this->createMock(Description::class);
        $testee = new Testee($bemFactory, $title, $description);

        Monkey\Functions\expect('is_home')
            ->once()
            ->andReturn(true);

        Monkey\Filters\expectApplied(Testee::FILTER_DATA)
            ->once();

        $bemFactory
            ->expects($this->once())
            ->method('createService')
            ->willReturn($bem);

        $title
            ->expects($this->once())
            ->method('forArchive');

        $description
            ->expects($this->once())
            ->method('forArchive');

        $title
            ->expects($this->once())
            ->method('forHome');

        $description
            ->expects($this->once())
            ->method('forHome');

        $bem
            ->expects($this->exactly(2))
            ->method('forElement')
            ->withConsecutive(['title'], ['description']);

        $testee->data();

        self::assertTrue(true);
    }
}

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

namespace WordPressModel\Tests\Unit\Model;

use ProjectTestsHelper\Phpunit\TestCase;
use WordPressModel\Model\ArchiveTitle as Testee;
use WordPressModel\Model\Title;
use Brain\Monkey;

class ArchiveTitleTest extends TestCase
{
    /**
     * Test Instance
     */
    public function testsInstance()
    {
        $title = $this->createMock(Title::class);
        $sut = new Testee($title);

        self::assertInstanceOf(Testee::class, $sut);
    }

    /**
     * Test Title for Page for Posts Data Model Contains the Proper Value
     */
    public function testTitleForPageForPosts()
    {
        $title = $this->createMock(Title::class);
        $testee = new Testee($title);

        Monkey\Functions\expect('is_home')
            ->once()
            ->andReturn(true);

        $title
            ->expects($this->once())
            ->method('forHome')
            ->willReturn('Title for Home');

        Monkey\Filters\expectApplied(Testee::FILTER_DATA)
            ->once()
            ->with([
                'value' => 'Title for Home',
            ]);

        $testee->data();
    }

    /**
     * Test Title for Archive Data Model Contains the Proper Value
     */
    public function testTitleForArchive()
    {
        $title = $this->createMock(Title::class);
        $testee = new Testee($title);

        Monkey\Functions\expect('is_home')
            ->once()
            ->andReturn(false);

        $title
            ->expects($this->once())
            ->method('forArchive')
            ->willReturn('Title for Archive');

        Monkey\Filters\expectApplied(Testee::FILTER_DATA)
            ->once()
            ->with([
                'value' => 'Title for Archive',
            ]);

        $testee->data();
    }
}

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
use WordPressModel\Model\ArchiveDescription as Testee;
use WordPressModel\Model\ArchiveDescription;
use WordPressModel\Factory\DescriptionFactory;
use Brain\Monkey;
use Widoz\Bem;

class ArchiveDescriptionTest extends TestCase
{
    /**
     * Test Testee Instance
     */
    public function testInstance()
    {
        $bem = $this->createMock(Bem\Service::class);
        $description = $this->createMock(DescriptionFactory::class);
        $testee = new Testee($bem, $description);

        self::assertInstanceOf(Testee::class, $testee);
    }

    /**
     * Test the Page for Posts Description it's in the Model Data when `is_home` return true
     */
    public function testDescriptionForPageForPosts()
    {
        $valuable = $this->createMock(Bem\Valuable::class);
        $bem = $this->createMock(Bem\Service::class);
        $description = $this->createMock(DescriptionFactory::class);
        $testee = new Testee($bem, $description);

        Monkey\Functions\expect('is_home')
            ->once()
            ->andReturn(true);

        $description
            ->expects($this->once())
            ->method('forHome')
            ->willReturn('Description for Page For Posts');

        $bem
            ->expects($this->once())
            ->method('forElement')
            ->with('description')
            ->willReturn($valuable);

        Monkey\Filters\expectApplied(Testee::FILTER_DATA)
            ->once()
            ->with([
                'description' => [
                    'content' => 'Description for Page For Posts',
                    'attributes' => [
                        'class' => $valuable
                    ],
                ],
            ]);

        /** @var ArchiveDescription $testee */
        $testee->data();
    }

    /**
     * Test the Description for Archive it's in the Model data when `is_home` return false.
     */
    public function testDescriptionForArchive()
    {
        $valuable = $this->createMock(Bem\Valuable::class);
        $bem = $this->createMock(Bem\Service::class);
        $description = $this->createMock(DescriptionFactory::class);
        $testee = new Testee($bem, $description);

        Monkey\Functions\expect('is_home')
            ->once()
            ->andReturn(false);

        $description
            ->expects($this->once())
            ->method('forArchive')
            ->willReturn('Description for Archive');

        $bem
            ->expects($this->once())
            ->method('forElement')
            ->with('description')
            ->willReturn($valuable);

        Monkey\Filters\expectApplied(Testee::FILTER_DATA)
            ->once()
            ->with([
                'description' => [
                    'content' => 'Description for Archive',
                    'attributes' => [
                        'class' => $valuable
                    ],
                ],
            ]);

        /** @var ArchiveDescription $testee */
        $testee->data();
    }
}

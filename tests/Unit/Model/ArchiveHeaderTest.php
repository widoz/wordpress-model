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

use Widoz\Bem;
use WordPressModel\Model\ArchiveHeader as Testee;
use WordPressModel\Model\Title;
use WordPressModel\Model\Description;
use \Brain\Monkey;
use ProjectTestsHelper\Phpunit\TestCase;

class ArchiveHeaderTest extends TestCase
{
    /**
     * Test Archive Header Data Model Contains the Proper Values
     */
    public function testArchiveHeaderData()
    {
        $bem = $this->createMock(Bem\Service::class);
        $title = $this->createMock(Title::class);
        $description = $this->createMock(Description::class);
        $testee = new Testee($bem, $title, $description);

        Monkey\Functions\expect('is_home')
            ->once()
            ->andReturn(false);

        $title
            ->expects($this->once())
            ->method('forArchive')
            ->willReturn('Title for Archive');

        $description
            ->expects($this->once())
            ->method('forArchive')
            ->willReturn('Description for Archive');

        $titleValue = $this->createMock(Bem\Valuable::class);
        $descriptionValue = $this->createMock(Bem\Valuable::class);
        $bem
            ->expects($this->exactly(2))
            ->method('forElement')
            ->withConsecutive(['title'], ['description'])
            ->willReturnOnConsecutiveCalls(
                $titleValue,
                $descriptionValue
            );

        Monkey\Filters\expectApplied(Testee::FILTER_DATA)
            ->once()
            ->with([
                'container' => [
                    'attributes' => [
                        'class' => $bem,
                    ],
                ],
                'title' => [
                    'text' => 'Title for Archive',
                    'attributes' => [
                        'class' => $titleValue,
                    ],
                ],
                'description' => [
                    'text' => 'Description for Archive',
                    'attributes' => [
                        'class' => $descriptionValue,
                    ],
                ],
            ]);

        $testee->data();
    }

    /**
     * Test Archive Header for Page for Posts Data Model Contains the Proper Values
     */
    public function testArchiveHeaderDataForPageForPosts()
    {
        $bem = $this->createMock(Bem\Service::class);
        $title = $this->createMock(Title::class);
        $description = $this->createMock(Description::class);
        $testee = new Testee($bem, $title, $description);

        Monkey\Functions\expect('is_home')
            ->once()
            ->andReturn(true);

        $title
            ->expects($this->once())
            ->method('forHome')
            ->willReturn('Title for Home');

        $description
            ->expects($this->once())
            ->method('forHome')
            ->willReturn('Description for Home');

        $titleValue = $this->createMock(Bem\Valuable::class);
        $descriptionValue = $this->createMock(Bem\Valuable::class);
        $bem
            ->expects($this->exactly(2))
            ->method('forElement')
            ->withConsecutive(['title'], ['description'])
            ->willReturnOnConsecutiveCalls(
                $titleValue,
                $descriptionValue
            );

        Monkey\Filters\expectApplied(Testee::FILTER_DATA)
            ->once()
            ->with([
                'container' => [
                    'attributes' => [
                        'class' => $bem,
                    ],
                ],
                'title' => [
                    'text' => 'Title for Home',
                    'attributes' => [
                        'class' => $titleValue,
                    ],
                ],
                'description' => [
                    'text' => 'Description for Home',
                    'attributes' => [
                        'class' => $descriptionValue,
                    ],
                ],
            ]);

        $testee->data();
    }
}

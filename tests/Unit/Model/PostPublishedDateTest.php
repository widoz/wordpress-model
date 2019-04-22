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
use Widoz\Bem\Service;
use WordPressModel\Model\DayArchiveLink;
use WordPressModel\Model\PostDateTime;
use WordPressModel\Model\PostPublishedDate as Testee;
use Brain\Monkey\Filters;
use WordPressModel\Model\PostPublishedDate;
use WordPressModel\Model\Time;

/**
 * Class PostPublishedDateTest
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class PostPublishedDateTest extends TestCase
{
    /**
     * Test Instance
     */
    public function testInstance()
    {
        $bem = $this->createMock(Service::class);
        $post = $this->getMockBuilder('WP_Post')->getMock();
        $dayArchiveLink = $this->createMock(DayArchiveLink::class);
        $postDateTime = $this->createMock(PostDateTime::class);
        $time = $this->createMock(Time::class);
        $testee = new Testee($bem, $post, $dayArchiveLink, $postDateTime, $time, 'Y-m-d');

        self::assertInstanceOf(Testee::class, $testee);
    }

    /**
     * Test Data
     */
    public function testFilterGetAppliedWithCorrectData()
    {
        $expectedDayArchiveLinkData = ['Expected DayArchiveLink Data'];

        $bem = $this->createMock(Service::class);
        $post = $this->getMockBuilder('WP_Post')->getMock();
        $dayArchiveLink = $this->createMock(DayArchiveLink::class);
        $postDateTime = $this->createMock(PostDateTime::class);
        $time = $this->createMock(Time::class);
        $dateTimeFormat = 'Y-m-d';
        $testee = new Testee($bem, $post, $dayArchiveLink, $postDateTime, $time, $dateTimeFormat);

        $dayArchiveLink
            ->expects($this->once())
            ->method('data')
            ->willReturn($expectedDayArchiveLinkData);

        Filters\expectApplied(PostPublishedDate::FILTER_DATA, [
                'container' => [
                    'attributes' => [
                        'class' => $bem,
                    ],
                ],
                'link' => $expectedDayArchiveLinkData,
                'time' => $time,
            ]
        );

        $testee->data();
    }
}

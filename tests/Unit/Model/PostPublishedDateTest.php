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
        $testee = new Testee($bem, $post, $dayArchiveLink, $postDateTime, 'Y-m-d');

        self::assertInstanceOf(Testee::class, $testee);
    }

    /**
     * Test Data
     */
    public function testFilterGetAppliedWithCorrectData()
    {
        $expectedPostDateTimeValue = 'Expected Post Date Time Value';
        $expectedTimeValue = 'Expected Time Value';
        $expectedDayArchiveLinkData = ['Expected DayArchiveLink Data'];

        $bem = $this->createMock(Service::class);
        $post = $this->getMockBuilder('WP_Post')->getMock();
        $dayArchiveLink = $this->createMock(DayArchiveLink::class);
        $postDateTime = $this->createMock(PostDateTime::class);
        $dateTimeFormat = 'Y-m-d';
        $testee = new Testee($bem, $post, $dayArchiveLink, $postDateTime, $dateTimeFormat);

        $postDateTime
            ->expects($this->exactly(2))
            ->method('date')
            ->withConsecutive(
                [$post, $dateTimeFormat],
                [$post, 'l, F j, Y g:i a']
            )
            ->willReturnOnConsecutiveCalls(
                $expectedPostDateTimeValue,
                $expectedTimeValue
            );

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
                'time' => [
                    'value' => $expectedTimeValue,
                    'attributes' => [
                        'datetime' => $expectedPostDateTimeValue,
                    ],
                ],
            ]
        );

        $testee->data();
    }
}

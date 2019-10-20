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
use WordPressModel\Exception\InvalidPostDateTimeException;
use WordPressModel\Model\DayArchiveLink;
use WordPressModel\Model\PostPublishedDate as Testee;
use Brain\Monkey\Filters;
use WordPressModel\Model\PostPublishedDate;
use WordPressModel\Model\PostDateTime;

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
        $dayArchiveLink = $this->createMock(DayArchiveLink::class);
        $time = $this->createMock(PostDateTime::class);
        $testee = new Testee($bem, $dayArchiveLink, $time);

        self::assertInstanceOf(Testee::class, $testee);
    }

    /**
     * Test Data
     * @throws InvalidPostDateTimeException
     */
    public function testFilterGetAppliedWithCorrectData()
    {
        $expectedDayArchiveLinkData = ['Expected DayArchiveLink Data'];

        $bem = $this->createMock(Service::class);
        $dayArchiveLink = $this->createMock(DayArchiveLink::class);
        $time = $this->createMock(PostDateTime::class);
        $testee = new Testee($bem, $dayArchiveLink, $time);

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

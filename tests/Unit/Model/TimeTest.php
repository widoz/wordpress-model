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
use WordPressModel\Model\PostDateTime;
use WordPressModel\Model\Time as Testee;
use Brain\Monkey\Filters;

/**
 * Class TimeTest
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class TimeTest extends TestCase
{
    /**
     * Test Instance
     */
    public function testInstance()
    {
        $post = $this->getMockBuilder('WP_Post')->getMock();
        $postDateTime = $this->createMock(PostDateTime::class);
        $dateTimeFormat = 'Y-m-d';
        $testee = new Testee($post, $postDateTime, $dateTimeFormat);

        self::assertInstanceOf(Testee::class, $testee);
    }

    /**
     * Test Data
     */
    public function testFilterGetAppliedWithCorrectData()
    {
        $expectedPostDateTimeValue = 'Expected Post Date Time Value';
        $expectedTimeValue = 'Expected Time Value';

        $post = $this->getMockBuilder('WP_Post')->getMock();
        $postDateTime = $this->createMock(PostDateTime::class);
        $dateTimeFormat = 'Y-m-d';
        $testee = new Testee($post, $postDateTime, $dateTimeFormat);

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

        Filters\expectApplied(Testee::FILTER_DATA)
            ->once()
            ->with([
                'text' => $expectedTimeValue,
                'attributes' => [
                    'datetime' => $expectedPostDateTimeValue,
                ],
            ]);

        $testee->data();
    }
}

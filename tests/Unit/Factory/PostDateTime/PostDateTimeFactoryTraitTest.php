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

namespace WordPressModel\Tests\Unit\Factory\PostDateTime;

use DateTimeImmutable;
use DateTimeZone;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\MockObject\MockObject;
use WordPressModel\Exception\DateTimeException;
use WordPressModel\Factory\PostDateTime\DateTimeFormat;
use WordPressModel\Factory\PostDateTime\PostDateTimeFactoryTrait as Testee;
use WordPressModel\Tests\TestCase;

/**
 * Class PostDateTimeFactoryTraitTest
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class PostDateTimeFactoryTraitTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * Test Create
     */
    public function testCreate()
    {
        {
            $dateFormatStub = 'Y/m/d';
            $timeFormatStub = 'H:i:s';
            $dateTimeSeparatorStub = ' ';

            $dateTimeZoneStringStub = 'Europe/Rome';

            $dateStub = date($dateFormatStub);
            $timeStub = date($timeFormatStub);

            $post = $this->getMockBuilder('\\WP_Post')->getMock();
            $dateTimeZone = $this
                ->getMockBuilder(DateTimeZone::class)
                ->setConstructorArgs([$dateTimeZoneStringStub])
                ->getMock();
            $dateTimeFormat = $this
                ->getMockBuilder(DateTimeFormat::class)
                ->setConstructorArgs([$dateFormatStub, $timeFormatStub, $dateTimeZoneStringStub])
                ->setMethods(['date', 'time', 'separator'])
                ->getMock();

            /** @var MockObject $testee */
            $testee = $this->getMockForTrait(
                Testee::class,
                [],
                '',
                false,
                false,
                true,
                ['time']
            );
        }

        {
            $dateTimeFormat
                ->expects($this->once())
                ->method('date')
                ->willReturn($dateFormatStub);

            $dateTimeFormat
                ->expects($this->once())
                ->method('time')
                ->willReturn($timeFormatStub);

            $dateTimeFormat
                ->expects($this->once())
                ->method('separator')
                ->willReturn($dateTimeSeparatorStub);

            $testee
                ->expects($this->exactly(2))
                ->method('time')
                ->withConsecutive(
                    [$post, $dateFormatStub],
                    [$post, $timeFormatStub]
                )
                ->willReturnOnConsecutiveCalls(
                    $dateStub,
                    $timeStub
                );
        }

        {
            $result = $testee->create($post, $dateTimeFormat, $dateTimeZone);
        }

        {
            self::assertInstanceOf(DateTimeImmutable::class, $result);

            $dateTimeImmutable = new DateTimeImmutable(
                "{$dateStub}{$dateTimeSeparatorStub}{$timeStub}",
                new DateTimeZone($dateTimeZoneStringStub)
            );

            self::assertEquals($dateTimeImmutable, $result);
        }
    }
}

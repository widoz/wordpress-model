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

namespace WordPressModel\Tests\Functional\Factory;

use function Brain\Monkey\Functions\expect;
use DateTimeZone;
use ProjectTestsHelper\Phpunit\TestCase;
use WordPressModel\Factory\WpDateTimeZoneFactory as Testee;

/**
 * Class WpDateTimeZoneFactoryTest
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class WpDateTimeZoneFactoryTest extends TestCase
{
    /**
     * Test TimeZone from String
     */
    public function testCreateByTimeZoneString()
    {
        $dateTimeZoneStringStub = 'Europe/Rome';

        $testee = new Testee();

        expect('get_option')
            ->once()
            ->with('timezone_string')
            ->andReturn($dateTimeZoneStringStub);

        $result = $testee->create();

        self::assertInstanceOf(DateTimeZone::class, $result);

        $dateTimeZone = new DateTimeZone($dateTimeZoneStringStub);
        self::assertEquals($dateTimeZone, $result);
    }

    /**
     * Test TimeZone from Gmt Offset
     *
     * @dataProvider gmtOffsetValues
     */
    public function testCreateByGmtOffset($offsetStub, $expected)
    {
        $testee = new Testee();

        expect('get_option')
            ->once()
            ->with('timezone_string')
            ->andReturn(false)
            ->andAlsoExpectIt()
            ->once()
            ->with('gmt_offset')
            ->andReturn($offsetStub);

        $result = $testee->create();

        self::assertSame($expected, $result->getName());
    }

    /**
     * Provide Offset Values and their DateTimeZone
     *
     * @return array
     */
    public function gmtOffsetValues(): array
    {
        return [
            ['1', '+01:00'],
            ['2', '+02:00'],
            ['0', 'UTC'],
            ['', 'UTC'],
            ['-1', '-01:00'],
            ['-2', '-02:00'],
        ];
    }
}

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

use WordPressModel\Exception\InvalidPostDateTimeException;
use function date;
use DateTime;
use function explode;
use ProjectTestsHelper\Phpunit\TestCase;
use Brain\Monkey\Filters;
use Brain\Monkey\Functions;
use Widoz\Bem\Service;
use Widoz\Bem\Valuable;
use WordPressModel\Factory\PostDateTime\PostDateTimeFactory;
use WordPressModel\Model\DayArchiveLink as Testee;
use WordPressModel\Factory\PostDateTime\CreatedDateTimeFactory;

/**
 * Class DayArchiveLinkTest
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class DayArchiveLinkTest extends TestCase
{
    /**
     * Test Instance
     */
    public function testInstance()
    {
        $bem = $this->createMock(Service::class);
        $post = $this->getMockBuilder('\\WP_Post')->getMock();
        $text = 'Inner Text';
        $postDateTimeFactory = $this
            ->getMockBuilder(PostDateTimeFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();
        $testee = new Testee($bem, $post, $text, $postDateTimeFactory);

        self::assertInstanceOf(Testee::class, $testee);
    }

    /**
     * Test Data Model Contains Correct Values and Filter is Applied
     * @throws InvalidPostDateTimeException
     */
    public function testFilterGetAppliedWithCorrectData()
    {
        $linkDateFormatStub = 'Y m d';
        $postDateTimeStub = $this
            ->getMockBuilder(DateTime::class)
            ->disableOriginalConstructor()
            ->setMethods(['format'])
            ->getMock();

        $expectedClass = $this->createMock(Valuable::class);
        $expectedLink = 'Expected Link';
        $expectedDateTimeString = date($linkDateFormatStub);

        $bem = $this->createMock(Service::class);
        $post = $this->getMockBuilder('\\WP_Post')->getMock();
        $text = 'Inner Text';
        $postDateTimeFactory = $this
            ->getMockBuilder(PostDateTimeFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();
        $testee = new Testee($bem, $post, $text, $postDateTimeFactory);

        $postDateTimeFactory
            ->expects($this->once())
            ->method('create')
            ->with($post, 'created')
            ->willReturn($postDateTimeStub);

        $postDateTimeStub
            ->expects($this->once())
            ->method('format')
            ->with($linkDateFormatStub)
            ->willReturn($expectedDateTimeString);

        Functions\expect('get_day_link')
            ->once()
            ->with(...explode(' ', $expectedDateTimeString))
            ->andReturn($expectedLink);

        $bem
            ->expects($this->once())
            ->method('forElement')
            ->willReturn($expectedClass);

        Filters\expectApplied(
            Testee::FILTER_DATA,
            [
                'content' => $text,
                'attributes' => [
                    'href' => $expectedLink,
                    'class' => $expectedClass,
                ],
            ]
        );

        $testee->data();
    }
}

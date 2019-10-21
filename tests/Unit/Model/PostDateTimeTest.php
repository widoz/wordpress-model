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

use DateTime;
use ProjectTestsHelper\Phpunit\TestCase;
use ReflectionException;
use WordPressModel\Exception\DateTimeException;
use WordPressModel\Factory\PostDateTime\PostDateTimeFactory;
use WordPressModel\Model\PostDateTime as Testee;
use Brain\Monkey\Filters;

/**
 * Class TimeTest
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class PostDateTimeTest extends TestCase
{
    /**
     * Test Instance
     */
    public function testInstance()
    {
        $post = $this->getMockBuilder('\\WP_Post')->getMock();
        $postDateTimeFactory = $this->createMock(PostDateTimeFactory::class);
        $testee = new Testee($post, $postDateTimeFactory);

        self::assertInstanceOf(Testee::class, $testee);
    }

    /**
     * Test Data
     * @throws ReflectionException
     */
    public function testFilterGetAppliedWithCorrectData()
    {
        $expectedAttributeDateTime = 'attribute_datetime';
        $expectedPostDateTimeFormatted = 'post_date_time';

        $dateTimeStub = $this
            ->getMockBuilder(DateTime::class)
            ->disableOriginalConstructor()
            ->setMethods(['format'])
            ->getMock();

        $post = $this->getMockBuilder('\\WP_Post')->getMock();
        $postDateTimeFactory = $this
            ->getMockBuilder(PostDateTimeFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();
        $testee = $this->proxy(
            Testee::class,
            [$post, $postDateTimeFactory],
            []
        );

        $postDateTimeFactory
            ->expects($this->once())
            ->method('create')
            ->with($post, 'created')
            ->willReturn($dateTimeStub);

        $dateTimeStub
            ->expects($this->exactly(2))
            ->method('format')
            ->withConsecutive(
                ['Y/m/d'],
                ['l, F j, Y g:i a']
            )
            ->willReturnOnConsecutiveCalls(
                $expectedPostDateTimeFormatted,
                $expectedAttributeDateTime
            );

        Filters\expectApplied(Testee::FILTER_DATA)
            ->once()
            ->with(
                [
                    'content' => $expectedPostDateTimeFormatted,
                    'attributes' => [
                        'datetime' => $expectedAttributeDateTime,
                    ],
                ]
            );

        /**
         * @var Testee $testee
         */
        $testee->data();
    }

    /**
     * Test Data Empty is Returned Because DateTime Throw Exception
     * @throws ReflectionException
     */
    public function testDataEmptyBecauseIsNotPossibleToRetrieveDateValues()
    {
        $post = $this->getMockBuilder('\\WP_Post')->getMock();
        $postDateTimeFactory = $this
            ->getMockBuilder(PostDateTimeFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();
        $testee = $this->proxy(
            Testee::class,
            [$post, $postDateTimeFactory],
            []
        );

        $postDateTimeFactory
            ->expects($this->once())
            ->method('create')
            ->with($post, 'created')
            ->willThrowException(new DateTimeException());

        /** @var Testee $testee */
        $result = $testee->data();

        self::assertEquals([], $result);
    }
}

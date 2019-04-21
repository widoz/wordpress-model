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
use WordPressModel\Exception\InvalidPostDateException;
use WordPressModel\Model\PostDateTime as Testee;
use Brain\Monkey\Functions;

/**
 * Class PostDateTimeTest
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class PostDateTimeTest extends TestCase
{
    private static $validDateFormat = 'Y-m-d H:i:s';

    /**
     * Test Instance
     */
    public function testInstance()
    {
        $testee = new Testee();

        self::assertInstanceOf(Testee::class, $testee);
    }

    /**
     * Test the Post Modified Date
     */
    public function testModifiedDate()
    {
        $post = $this->getMockBuilder('\WP_Post')->getMock();
        $testee = new Testee();

        Functions\expect('get_the_modified_date')
            ->once()
            ->with(self::$validDateFormat, $post)
            ->andReturn('Valid Date Time');

        $date = $testee->modifiedDate($post, self::$validDateFormat);
        self::assertSame('Valid Date Time', $date);
    }

    /**
     * Test the Post Modified Date Cannot be Retrieved and Throw an
     * InvalidPostDateException
     */
    public function testModifiedDateThrowInvalidPostDateExceptionBecauseDateCannotBeRetrieved()
    {
        $post = $this->getMockBuilder('\WP_Post')->getMock();
        $post->ID = 1;
        $testee = new Testee();

        Functions\expect('get_the_modified_date')
            ->once()
            ->with(self::$validDateFormat, $post)
            ->andReturn(false);

        $this->expectException(InvalidPostDateException::class);
        $this->expectExceptionMessage("Invalid post date time retrieved for post with ID: {$post->ID}");

        $testee->modifiedDate($post, self::$validDateFormat);
    }

    /**
     * Test the Post Modified Time
     */
    public function testModifiedTime()
    {
        $post = $this->getMockBuilder('\WP_Post')->getMock();
        $testee = new Testee();

        Functions\expect('get_the_modified_time')
            ->once()
            ->with(self::$validDateFormat, $post)
            ->andReturn('Valid Date Time');

        $date = $testee->modifiedTime($post, self::$validDateFormat);
        self::assertSame('Valid Date Time', $date);
    }

    /**
     * Test the Post Modified Date Cannot be Retrieved and Throw an
     * InvalidPostDateException
     */
    public function testModifiedTimeThrowInvalidPostDateExceptionBecauseDateCannotBeRetrieved()
    {
        $post = $this->getMockBuilder('\WP_Post')->getMock();
        $post->ID = 1;
        $testee = new Testee();

        Functions\expect('get_the_modified_time')
            ->once()
            ->with(self::$validDateFormat, $post)
            ->andReturn(false);

        $this->expectException(InvalidPostDateException::class);
        $this->expectExceptionMessage("Invalid post date time retrieved for post with ID: {$post->ID}");

        $testee->modifiedTime($post, self::$validDateFormat);
    }


    /**
     * Test the Post Date
     */
    public function testDate()
    {
        $post = $this->getMockBuilder('\WP_Post')->getMock();
        $testee = new Testee();

        Functions\expect('get_the_date')
            ->once()
            ->with(self::$validDateFormat, $post)
            ->andReturn('Valid Date Time');

        $date = $testee->date($post, self::$validDateFormat);
        self::assertSame('Valid Date Time', $date);
    }

    /**
     * Test the Post Date Cannot be Retrieved and Throw an
     * InvalidPostDateException
     */
    public function testDateThrowInvalidPostDateExceptionBecauseDateCannotBeRetrieved()
    {
        $post = $this->getMockBuilder('\WP_Post')->getMock();
        $post->ID = 1;
        $testee = new Testee();

        Functions\expect('get_the_date')
            ->once()
            ->with(self::$validDateFormat, $post)
            ->andReturn(false);

        $this->expectException(InvalidPostDateException::class);
        $this->expectExceptionMessage("Invalid post date time retrieved for post with ID: {$post->ID}");

        $testee->date($post, self::$validDateFormat);
    }

    /**
     * Test the Post Time
     */
    public function testTime()
    {
        $post = $this->getMockBuilder('\WP_Post')->getMock();
        $testee = new Testee();

        Functions\expect('get_the_time')
            ->once()
            ->with(self::$validDateFormat, $post)
            ->andReturn('Valid Date Time');

        $date = $testee->time($post, self::$validDateFormat);
        self::assertSame('Valid Date Time', $date);
    }

    /**
     * Test the Post Time Cannot be Retrieved and Throw an
     * InvalidPostDateException
     */
    public function testTimeThrowInvalidPostDateExceptionBecauseDateCannotBeRetrieved()
    {
        $post = $this->getMockBuilder('\WP_Post')->getMock();
        $post->ID = 1;
        $testee = new Testee();

        Functions\expect('get_the_time')
            ->once()
            ->with(self::$validDateFormat, $post)
            ->andReturn(false);

        $this->expectException(InvalidPostDateException::class);
        $this->expectExceptionMessage("Invalid post date time retrieved for post with ID: {$post->ID}");

        $testee->time($post, self::$validDateFormat);
    }

    /**
     * Test the Post Time
     */
    public function testDateTime()
    {
        $post = $this->getMockBuilder('\WP_Post')->getMock();
        $testee = new Testee();

        Functions\expect('get_the_date')
            ->once()
            ->with(self::$validDateFormat, $post)
            ->andReturn('Date');

        Functions\expect('get_the_time')
            ->once()
            ->with(self::$validDateFormat, $post)
            ->andReturn('Time');

        $date = $testee->dateTime($post, self::$validDateFormat, ' : ');
        self::assertSame('Date : Time', $date);
    }
}

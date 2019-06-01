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

namespace WordPressModel\Tests\Functional\Factory\PostDateTime;

use DateTime;
use DateTimeZone;
use ProjectTestsHelper\Phpunit\TestCase;
use WordPressModel\Factory\DateTimeZoneFactory;
use WordPressModel\Factory\PostDateTime\CreatedDateTimeFactory;
use WordPressModel\Factory\PostDateTime\DateTimeFormat;
use WordPressModel\Factory\PostDateTime\ModifiedDateTimeFactory;
use WordPressModel\Factory\PostDateTime\PostDateTimeFactory as Testee;

/**
 * Class PostDateTimeFactoryTest
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class PostDateTimeFactoryTest extends TestCase
{
    /**
     * Test Create Modified Date Time
     */
    public function testCreateModifiedDateTime()
    {
        {
            $type = 'modified';
            $dateTimeZone = new DateTimeZone('Europe/Rome');
            $dateTimeFormat = new DateTimeFormat('Y/m/d', 'H:i:s', ' ');

            $post = $this->getMockBuilder('\\WP_Post')->getMock();
            $modifiedDateTimeFactory = $this
                ->getMockBuilder(ModifiedDateTimeFactory::class)
                ->disableOriginalConstructor()
                ->setMethods(['create'])
                ->getMock();
            $createdDateTimeFactory = $this
                ->getMockBuilder(CreatedDateTimeFactory::class)
                ->disableOriginalConstructor()
                ->setMethods(['create'])
                ->getMock();
            $timeZoneFactory = $this
                ->getMockBuilder(DateTimeZoneFactory::class)
                ->setMethods(['create'])
                ->getMock();

            $testee = new Testee(
                $timeZoneFactory,
                $dateTimeFormat,
                $modifiedDateTimeFactory,
                $createdDateTimeFactory
            );
        }

        {
            $timeZoneFactory
                ->expects($this->once())
                ->method('create')
                ->willReturn($dateTimeZone);

            $modifiedDateTimeFactory
                ->expects($this->once())
                ->method('create')
                ->willReturn(new DateTime('now', $dateTimeZone));
        }

        {
            $testee->create($post, $type);
        }
    }
}

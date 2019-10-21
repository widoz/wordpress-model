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

use ReflectionException;
use function Brain\Monkey\Functions\expect;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use ProjectTestsHelper\Phpunit\TestCase;
use WordPressModel\Factory\PostDateTime\CreatedDateTimeFactory as Testee;

/**
 * Class CreatedDateTimeFactoryTest
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class CreatedDateTimeFactoryTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * Test Time
     * @throws ReflectionException
     */
    public function testTime()
    {
        $formatStub = 'Y/d/m';
        $postTimeStub = date($formatStub);

        $post = $this->getMockBuilder('\\WP_Post')->getMock();
        $testee = $this->proxy(
            Testee::class,
            [],
            ['bailIfInvalidValue']
        );

        expect('get_post_time')
            ->once()
            ->with($formatStub, false, $post, false)
            ->andReturn($postTimeStub);

        $testee
            ->expects($this->once())
            ->method('bailIfInvalidValue')
            ->with($postTimeStub, $post);

        $testee->time($post, $formatStub);
    }
}

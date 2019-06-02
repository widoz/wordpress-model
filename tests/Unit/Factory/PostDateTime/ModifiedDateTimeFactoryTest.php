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

use function Brain\Monkey\Functions\expect;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use ProjectTestsHelper\Phpunit\TestCase;
use WordPressModel\Factory\PostDateTime\ModifiedDateTimeFactory as Testee;

/**
 * Class ModifiedDateTimeFactoryTest
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class ModifiedDateTimeFactoryTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * Test Time
     */
    public function testTime()
    {
        {
            $formatStub = 'Y/d/m';
            $postTimeStub = date($formatStub);

            $post = $this->getMockBuilder('\\WP_Post')->getMock();
            list($testee, $testeeMethod) = $this->buildTesteeMethodMock(
                Testee::class,
                [],
                'time',
                ['bailIfInvalidValue']
            );
        }

        {
            expect('get_post_modified_time')
                ->once()
                ->with($formatStub, $post)
                ->andReturn($postTimeStub);

            $testee
                ->expects($this->once())
                ->method('bailIfInvalidValue')
                ->with($postTimeStub, $post);
        }

        {
            $testeeMethod->invoke($testee, $post, $formatStub);
        }
    }
}

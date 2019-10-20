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

use ReflectionException;
use function Brain\Monkey\Filters\expectApplied;
use function Brain\Monkey\Functions\expect;
use ProjectTestsHelper\Phpunit\TestCase;
use Widoz\Bem\Service as ServiceBem;
use Widoz\Bem\Valuable;
use WordPressModel\Model\PostTitle as Testee;
use WordPressModel\Model\PostTitle;

/**
 * Class PostTitleTest
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class PostTitleTest extends TestCase
{
    /**
     * Test Instance
     */
    public function testInstance()
    {
        /*
         * Setup Dependencies
         */
        $bem = $this->createMock(ServiceBem::class);
        $post = $this->getMockBuilder('\\WP_Post')->getMock();

        /*
         * Execute Test
         */
        $testee = new Testee($bem, $post);

        self::assertInstanceOf(Testee::class, $testee);
    }

    /**
     * Test Data Model Contains the Correct Values and Filter is Applied
     * @throws ReflectionException
     */
    public function testFilterDataIsAppliedCorrectly()
    {
        /*
         * Stubs
         */
        $postTitle = uniqid((string)mt_rand());
        $bemElementTitle = $this->createMock(Valuable::class);

        /*
         * Setup Dependencies
         */
        $bem = $this
            ->getMockBuilder(ServiceBem::class)
            ->disableOriginalConstructor()
            ->setMethods(['forElement'])
            ->getMock();
        $post = $this->getMockBuilder('\\WP_Post')->getMock();

        /*
         * Setup Test
         */
        list($testee, $testeeMethod) = $this->buildTesteeMethodMock(
            Testee::class,
            [$bem, $post],
            'data',
            []
        );

        /*
         * Expect to call `get_the_title` to retrieve the post title
         */
        expect('get_the_title')
            ->once()
            ->with($post)
            ->andReturn($postTitle);

        /*
         * Expect to set the attribute class for the title from the bem
         * service.
         *
         * What we expect is to set the `element` part
         */
        $bem
            ->expects($this->once())
            ->method('forElement')
            ->with('title')
            ->willReturn($bemElementTitle);

        /*
         * Expect the filter for the model is applied with the correct data.
         */
        expectApplied(PostTitle::FILTER_DATA)
            ->once()
            ->with([
                'title' => [
                    'content' => $postTitle,
                    'attributes' => [
                        'class' => $bemElementTitle,
                    ],
                ],
            ]);

        /*
         * Execute Test
         */
        $testeeMethod->invoke($testee);
    }
}

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

use Brain\Monkey\Functions;
use Brain\Monkey\Filters;
use ProjectTestsHelper\Phpunit\TestCase;
use Widoz\Bem\Service;
use Widoz\Bem\Valuable;
use WordPressModel\Model\MainNavMenu as Testee;

/**
 * Class MainNavMenuTest
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class MainNavMenuTest extends TestCase
{
    /**
     * Test Instance
     */
    public function testInstance()
    {
        $themeLocation = 'location';
        $id = 'id';
        $depth = 2;
        $callback = function() {};
        $walker = $this
            ->getMockBuilder('Walker')
            ->disableOriginalConstructor()
            ->getMock();
        $bem = $this->createMock(Service::class);

        $testee = new Testee($bem, $themeLocation, $id, $depth, $callback, $walker);

        self::assertInstanceOf(Testee::class, $testee);
    }

    /**
     * Test Data
     */
    public function testFilterGetAppliedWithCorrectData()
    {
        $themeLocation = 'location';
        $id = 'id';
        $depth = 2;
        $callback = function() {};

        $bem = $this
            ->getMockBuilder(Service::class)
            ->disableOriginalConstructor()
            ->setMethods(['forElement'])
            ->getMock();
        $walker = $this
            ->getMockBuilder('Walker')
            ->disableOriginalConstructor()
            ->getMock();
        $valuable = $this->createMock(Valuable::class);
        $testee = new Testee($bem, $themeLocation, $id, 2, $callback, $walker);

        $data = [
            'container' => [
                'attributes' => [
                    'id' => 'main-menu',
                    'class' => $bem,
                ],
            ],
            'link' => [
                'text' => 'Jump To Content',
                'attributes' => [
                    'href' => '#content',
                    'id' => 'jump_to_content',
                    'class' => $valuable,
                ],
            ],
            'arguments' => [
                'theme_location' => $themeLocation,
                'menu_id' => $id,
                'container' => '',
                'depth' => $depth,
                'fallback_cb' => $callback,
                'menu_class' => $valuable,
                'items_wrap' => '<ul class="%2$s">%3$s</ul>',
                'walker' => $walker,
            ],
        ];

        Functions\expect('has_nav_menu')
            ->once()
            ->with($themeLocation)
            ->andReturn(true);

        Filters\expectApplied(Testee::FILTER_JUMP_TO_CONTENT_HREF)
            ->once()
            ->with('#content');

        $bem
            ->expects($this->exactly(2))
            ->method('forElement')
            ->withConsecutive(['to-content'], ['items'])
            ->willReturnOnConsecutiveCalls($valuable, $valuable);

        Filters\expectApplied(Testee::FILTER_DATA)
            ->once()
            ->with($data);

        Filters\expectApplied(Testee::FILTER_DATA . "_{$id}")
            ->once()
            ->with($data);

        $testee->data();
    }

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        parent::setUp();

        Functions\when('__')->returnArg();
    }
}

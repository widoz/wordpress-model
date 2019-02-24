<?php # -*- coding: utf-8 -*-
// phpcs:disable

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
use Widoz\Bem;
use WordPressModel\Utils\CssProperties;
use WordPressModel\Model\Brand as Testee;

/**
 * Class BrandTest
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class BrandTest extends TestCase
{
    public function testInstance()
    {
        $bem = $this->createMock(Bem\Service::class);
        $cssProperties = $this->createMock(CssProperties::class);
        $testee = new Testee($bem, $cssProperties);

        self::assertInstanceOf(Testee::class, $testee);
    }

    public function testMayBeDisplayedReturnEmptyData()
    {
        $bem = $this->createMock(Bem\Service::class);
        $cssProperties = $this->createMock(CssProperties::class);

        Functions\expect('get_bloginfo')
            ->once()
            ->with('name')
            ->andReturn('');

        $testee = new Testee($bem, $cssProperties);

        $data = $testee->data();

        self::assertEmpty($data);
    }

    public function testFilterDataAppliedEvenIfBlogNameIsEmptyString()
    {
        $bem = $this->createMock(Bem\Service::class);
        $cssProperties = $this->createMock(CssProperties::class);
        $testee = new Testee($bem, $cssProperties);

        Functions\expect('get_bloginfo')
            ->once()
            ->with('name')
            ->andReturn('');

        Filters\expectApplied(Testee::FILTER_DATA)
            ->once()
            ->with([]);

        $testee->data();

        self::assertTrue(true);
    }

    public function testFilterGetAppliedWithCorrectData()
    {
        $bem = $this->createMock(Bem\Service::class);
        $cssProperties = $this->createMock(CssProperties::class);
        $testee = new Testee($bem, $cssProperties);

        Functions\expect('get_header_textcolor')
            ->once()
            ->andReturn('ffffff');

        Functions\expect('sanitize_hex_color_no_hash')
            ->once()
            ->with('ffffff')
            ->andReturnFirstArg();

        Functions\expect('get_bloginfo')
            ->with('name')
            ->andReturn('blog_name');

        Functions\expect('home_url')
            ->once()
            ->with('/')
            ->andReturn('home_url');

        Functions\expect('get_bloginfo')
            ->with('description')
            ->andReturn('blog_description');

        $linkValue = $this->createMock(Bem\Valuable::class);
        $descriptionValue = $this->createMock(Bem\Valuable::class);

        $bem
            ->expects($this->exactly(2))
            ->method('forElement')
            ->withConsecutive(['link'], ['description'])
            ->willReturnOnConsecutiveCalls(
                $linkValue,
                $descriptionValue
            );

        $cssProperties
            ->expects($this->once())
            ->method('flat')
            ->with([
                'color' => '#ffffff',
            ])
            ->willReturn('color:#ffffff');

        Filters\expectApplied(Testee::FILTER_DATA)
            ->once()
            ->with([
                'container' => [
                    'attributes' => [
                        'class' => $bem,
                    ],
                ],
                'name' => [
                    'text' => 'blog_name',
                ],
                'link' => [
                    'attributes' => [
                        'href' => 'home_url',
                        'class' => $linkValue,
                        'style' => 'color:#ffffff',
                    ],
                ],
                'description' => [
                    'text' => 'blog_description',
                    'attributes' => [
                        'class' => $descriptionValue,
                    ],
                ],
            ]);

        $testee->data();

        self::assertTrue(true);
    }
}

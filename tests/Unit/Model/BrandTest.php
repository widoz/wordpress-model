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
    /**
     * Test Instance
     */
    public function testInstance()
    {
        $bem = $this->createMock(Bem\Service::class);
        $cssProperties = $this->createMock(CssProperties::class);
        $testee = new Testee($bem, $cssProperties);

        self::assertInstanceOf(Testee::class, $testee);
    }

    /**
     * Test Data Model is Empty if Blog Name is Empty String
     */
    public function testDataModelIsEmptyIfBlogNameIsEmptyString()
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
    }

    /**
     * Test Data Model Contains Correct Values and Data Filter is applied
     */
    public function testFilterGetAppliedWithCorrectData()
    {
        $bem = $this->createMock(Bem\Service::class);
        $cssProperties = $this->createMock(CssProperties::class);
        $linkValue = $this->createMock(Bem\Valuable::class);
        $descriptionValue = $this->createMock(Bem\Valuable::class);

        $testee = new Testee($bem, $cssProperties);

        Functions\expect('get_bloginfo')
            ->once()
            ->with('name')
            ->andReturn('blog_name');

        Functions\expect('home_url')
            ->once()
            ->with('/')
            ->andReturn('home_url');

        Functions\expect('get_header_textcolor')
            ->once()
            ->andReturn('header_color');

        Functions\expect('sanitize_hex_color_no_hash')
            ->once()
            ->with('header_color')
            ->andReturnFirstArg();

        Functions\expect('get_bloginfo')
            ->once()
            ->with('description')
            ->andReturn('blog_description');

        $cssProperties
            ->expects($this->once())
            ->method('flat')
            ->with(['color' => '#header_color'])
            ->willReturn('color:#header_color');

        $bem
            ->expects($this->exactly(2))
            ->method('forElement')
            ->withConsecutive(['link'], ['description'])
            ->willReturnOnConsecutiveCalls(
                $linkValue,
                $descriptionValue
            );

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
                        'style' => 'color:#header_color',
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

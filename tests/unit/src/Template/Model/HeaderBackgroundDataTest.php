<?php # -*- coding: utf-8 -*-

/*
 * This file is part of the WordPress Theme Model package.
 *
 * (c) Guido Scialfa <dev@guidoscialfa.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WordPressModel\Tests\Unit\Model;

use Brain\Monkey\Functions;
use WordPressModel\Model\HeaderBackground;
use WordPressModel\Tests\TestCase;

class HeaderBackgroundDataTest extends TestCase
{
    /**
     * Assert Data is empty if theme doesn't have custom header support.
     */
    public function testDataEmptyIfNotHasSupport()
    {
        Functions\expect('current_theme_supports')
            ->with('custom-header')
            ->once()
            ->andReturn(false);

        $sut = new HeaderBackground();

        $response = $sut->data();

        $this->assertSame([], $response);
    }

    /**
     * Assert data is empty if theme has custom header support but video and images are not set.
     */
    public function testDataEmptyIfHasSupportButNoImageNorVideoAreSet()
    {
        Functions\expect('current_theme_supports')
            ->with('custom-header')
            ->once()
            ->andReturn(true);

        Functions\expect('is_header_video_active')
            ->once()
            ->andReturn(false);

        Functions\expect('has_header_image')
            ->once()
            ->andReturn(false);

        $sut = new HeaderBackground();

        $response = $sut->data();

        $this->assertSame([], $response);
    }

    /**
     * Assert data is empty if theme has custom header support and the video is active but
     * no video nor image has provided.
     *
     * `is_header_video_active` doesn't means the video is set as option but:
     *  Checks whether the custom header video is eligible to show on the current page.
     */
    public function testDataEmptyIfHasSupportAndVideoActiveButNotVideoNorImageIsSet()
    {
        Functions\expect('current_theme_supports')
            ->with('custom-header')
            ->once()
            ->andReturn(true);

        Functions\expect('is_header_video_active')
            ->once()
            ->andReturn(true);

        Functions\expect('has_header_video')
            ->once()
            ->andReturn(false);

        Functions\expect('has_header_image')
            ->once()
            ->andReturn(false);

        $sut = new HeaderBackground();

        $response = $sut->data();

        $this->assertSame([], $response);
    }

    /**
     * Assert valid data is provided for the header view
     */
    public function testDataReturnsValidVideoMarkup()
    {
        Functions\when('get_custom_header_markup')
            ->justReturn('<div>Markup</div>');

        Functions\when('has_header_image')
            ->justReturn(false);

        Functions\when('home_url')
            ->justReturn('/');

        Functions\when('get_header_image_tag')
            ->justReturn('<img src="" alt="" />');

        Functions\expect('current_theme_supports')
            ->with('custom-header')
            ->once()
            ->andReturn(true);

        Functions\expect('is_header_video_active')
            ->times(2)
            ->andReturn(true);

        Functions\expect('has_header_video')
            ->times(2)
            ->andReturn(true);

        $sut = new HeaderBackground();

        $response = $sut->data();

        $this->assertSame('<div>Markup</div>', $response['markup']);
    }
}

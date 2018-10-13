<?php # -*- coding: utf-8 -*-

/*
 * This file is part of the WordPress Theme Model Theme package.
 *
 * (c) Guido Scialfa <dev@guidoscialfa.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WordPressModel\Tests\Unit\Model;

use Brain\Monkey\Functions;
use Brain\Monkey\Filters;
use Widoz\Bem\BemPrefixed;
use WordPressModel\AttachmentImage;
use WordPressModel\Exception\InvalidAttachmentType;
use WordPressModel\Tests\TestCase;

class AttachmentImageTest extends TestCase
{
    public function testFigureImageData()
    {
        $postMock = \Mockery::mock('WP_Post');
        $postMock->ID = 1;

        Functions\expect('wp_attachment_is_image')
            ->once()
            ->with(1)
            ->andReturn(true);

        Functions\expect('wp_get_attachment_image_url')
            ->once()
            ->with(1, 'post-thumbnail')
            ->andReturn('image_url');

        Functions\expect('wp_get_attachment_caption')
            ->once()
            ->andReturn('Caption');

        Functions\expect('get_post_meta')
            ->once()
            ->with(1, '_wp_attachment_image_alt', true)
            ->andReturn('alt');

        $sut = new AttachmentImage(1, 'post-thumbnail', new BemPrefixed('block'));

        $response = $sut->data();

        self::assertEquals([
            'caption' => [
                'text' => 'Caption',
                'attributes' => [
                    'class' => 'block',
                ],
            ],
            'image' => [
                'attributes' => [
                    'url' => 'image_url',
                    'class' => 'block__image',
                    'alt' => 'alt',
                ],
            ],
        ], $response);
    }

    public function testExceptionIsThrowBecauseAttachmentIsntAnImage()
    {
        Functions\when('wp_attachment_is_image')
            ->justReturn(false);

        self::expectException(InvalidAttachmentType::class);

        $sut = new AttachmentImage(1, 'post-thumbnail', new BemPrefixed('block'));
        $sut->data();
    }

    public function testThatCaptionFilterIsApplied()
    {
        Functions\when('absint')
            ->justReturn(1);

        Functions\when('esc_html')
            ->returnArg(1);

        Functions\when('WordPressModel\\Functions\\ksesPost')
            ->returnArg(1);

        Functions\expect('wp_attachment_is_image')
            ->once()
            ->andReturn(true);

        Functions\expect('wp_get_attachment_image_url')
            ->once()
            ->andReturn('image_url');

        Functions\expect('get_post_meta')
            ->once()
            ->andReturn('');

        Functions\expect('wp_get_attachment_caption')
            ->once()
            ->andReturn('Caption');

        $sut = new AttachmentImage(1, '', new BemPrefixed('block'));
        $sut->data();

        self::assertTrue(Filters\applied(AttachmentImage::FILTER_CAPTION) > 0);
    }

    /**
     * @expectedException \WordpressModel\Exception\InvalidAttachmentType
     * @expectedExceptionMessage Attachment must be an image.
     */
    public function testInvalidAttachmentTypeExceptionIsThrownIfAttachmentIsntImage()
    {
        Functions\expect('wp_get_attachment_caption')
            ->once()
            ->andReturn('Caption');

        Functions\expect('wp_attachment_is_image')
            ->once()
            ->andReturn(false);

        $sut = new AttachmentImage(1, '', new BemPrefixed('block'));
        $sut->data();
    }
}

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
use Widoz\Bem\BemPrefixed;
use WordPressModel\Model\AttachmentImage;
use WordPressModel\Tests\TestCase;

class AttachmentImageTest extends TestCase
{
    public function testAttachmentImageData()
    {
        $postMock = \Mockery::mock('WP_Post');
        $postMock->ID = 1;

        Functions\expect('wp_attachment_is_image')
            ->once()
            ->with(1)
            ->andReturn(true);

        Functions\expect('wp_get_attachment_image_src')
            ->once()
            ->with(1, 'post-thumbnail')
            ->andReturn([
                'image_url',
                100,
                100,
                true,
            ]);

        Functions\expect('get_post_meta')
            ->once()
            ->with(1, '_wp_attachment_image_alt', true)
            ->andReturn('alt');

        $sut = new AttachmentImage(1, 'post-thumbnail', new BemPrefixed('block'));

        $response = $sut->data();

        self::assertEquals([
            'image' => [
                'attributes' => [
                    'url' => 'image_url',
                    'class' => 'block__image',
                    'alt' => 'alt',
                    'width' => 100,
                    'height' => 100,
                ],
            ],
        ], $response);
    }

    /**
     * @expectedException \WordpressModel\Exception\InvalidAttachmentType
     * @expectedExceptionMessage Attachment must be an image.
     */
    public function testInvalidAttachmentTypeExceptionIsThrownIfAttachmentIsntImage()
    {
        Functions\expect('wp_attachment_is_image')
            ->once()
            ->andReturn(false);

        $sut = new AttachmentImage(1, '', new BemPrefixed('block'));
        $sut->data();
    }
}

<?php # -*- coding: utf-8 -*-
// phpcs:disable

namespace WordPressModel\Tests\Unit\Template\Model;

use Brain\Monkey\Functions;
use Brain\Monkey\Filters;
use Widoz\Bem\BemPrefixed;
use WordPressModel\AttachmentImage;
use WordPressModel\FigureAttachmentImage;
use WordPressModel\Tests\TestCase;

class FigureAttachmentImageTest extends TestCase
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

        $sut = new FigureAttachmentImage(1, 'post-thumbnail', new BemPrefixed('block'));

        $response = $sut->data();

        self::assertEquals([
            'figure' => [
                'attributes' => [
                    'class' => 'block',
                ],
            ],
            'figcaption' => [
                'text' => 'Caption',
                'attributes' => [
                    'class' => 'block__caption',
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

    public function testThatCaptionFilterIsApplied()
    {
        Functions\when('absint')
            ->justReturn(1);

        Functions\when('esc_html')
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

        $sut = new FigureAttachmentImage(1, '', new BemPrefixed('block'));
        $sut->data();

        self::assertTrue(Filters\applied(FigureAttachmentImage::FILTER_CAPTION) > 0);
    }
}

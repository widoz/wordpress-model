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

use Brain\Monkey\Filters;
use Brain\Monkey\Functions;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use ReflectionException;
use WordPressModel\Model\AttachmentImage;
use WordPressModel\Tests\TestCase;
use WordPressModel\Model\PostThumbnail as Testee;

/**
 * Class PostThumbnailTest
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class PostThumbnailTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * Test Data
     */
    public function testFilterGetAppliedWithCorrectData()
    {
        $attachmentImageData = uniqid();
        $testeePermalink = uniqid();

        $post = $this->getMockBuilder('\\WP_Post')->getMock();
        $attachmentImage = $this->createMock(AttachmentImage::class);

        $testee = $this->proxy(
            Testee::class,
            [$post, $attachmentImage],
            ['permalink', 'hasThumbnail']
        );

        $attachmentImage
            ->expects($this->once())
            ->method('data')
            ->willReturn(['attachmentImage' => $attachmentImageData]);

        $testee
            ->expects($this->once())
            ->method('permalink')
            ->willReturn($testeePermalink);

        $testee
            ->expects($this->once())
            ->method('hasThumbnail')
            ->willReturn(true);

        Filters\expectApplied(Testee::FILTER_DATA)
            ->once()
            ->with([
                'link' => [
                    'attributes' => [
                        'href' => $testeePermalink,
                    ],
                ],
                'attachmentImage' => $attachmentImageData,
            ]);

        $testee->data();
    }

    /**
     * Test Permalink
     * @throws ReflectionException
     */
    public function testPermalink()
    {
        $postPermalinkStub = 'post_permalink_stub';

        $post = $this->getMockBuilder('WP_Post')->getMock();
        $attachmentImage = $this->createMock(AttachmentImage::class);
        $testee = $this->proxy(
            Testee::class,
            [$post, $attachmentImage],
            []
        );

        Functions\expect('get_permalink')
            ->once()
            ->with($post)
            ->andReturn($postPermalinkStub);

        Filters\expectApplied(Testee::FILTER_PERMALINK)
            ->once()
            ->with($postPermalinkStub)
            ->andReturn($postPermalinkStub);

        /**
         * @var Testee $testee
         */
        $response = $testee->permalink();

        self::assertSame($postPermalinkStub, $response);
    }

    /**
     * Test Post Thumbnail Exists
     * @throws ReflectionException
     */
    public function testPostThumbnailExists()
    {
        $post = $this->getMockBuilder('WP_Post')->getMock();
        $attachmentImage = $this->createMock(AttachmentImage::class);
        $testee = $this->proxy(
            Testee::class,
            [$post, $attachmentImage],
            []
        );

        Functions\expect('current_theme_supports')
            ->once()
            ->with('post-thumbnails')
            ->andReturn(true);

        Functions\expect('has_post_thumbnail')
            ->with($post)
            ->andReturn(true);

        /** @var Testee $testee */
        $response = $testee->hasThumbnail($testee);

        self::assertSame(true, $response);
    }
}

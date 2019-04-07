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
use Widoz\Bem\Service;
use Widoz\Bem\Valuable;
use WordPressModel\Attachment\Image\AlternativeText;
use WordPressModel\Attachment\Image\Source;
use WordPressModel\Model\AttachmentImage as Testee;
use ProjectTestsHelper\Phpunit\TestCase;
use WordPressModel\Model\AttachmentImage;

class AttachmentImageTest extends TestCase
{
    /**
     * Test Instance
     */
    public function testInstance()
    {
        $bem = $this->createMock(Service::class);
        $source = $this->createMock(Source::class);
        $alternativeText = $this->createMock(AlternativeText::class);
        $attachment = $this
            ->getMockBuilder('WP_Post')
            ->getMock();

        $testee = new Testee(
            $bem,
            $attachment,
            $source,
            $alternativeText
        );

        self::assertInstanceOf(Testee::class, $testee);
    }

    /**
     * Test Data Model Filter is Applied with the correct Values
     */
    public function testFilterGetAppliedWithCorrectValue()
    {
        $bem = $this->createMock(Service::class);
        $source = $this->createMock(Source::class);
        $alternativeText = $this->createMock(AlternativeText::class);
        $attachment = $this
            ->getMockBuilder('WP_Post')
            ->getMock();

        $alternativeText
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn('alt text');

        $imageBemValue = $this->createMock(Valuable::class);
        $bem
            ->expects($this->once())
            ->method('forElement')
            ->with('image')
            ->willReturn($imageBemValue);

        $testee = new Testee(
            $bem,
            $attachment,
            $source,
            $alternativeText
        );

        Filters\expectApplied(AttachmentImage::FILTER_DATA)
            ->once()
            ->with([
                'image' => [
                    'attributes' => [
                        'src' => '',
                        'width' => '',
                        'height' => '',
                        'alt' => 'alt text',
                        'class' => $imageBemValue,
                    ],
                ],
            ]);

        $testee->data();
    }
}

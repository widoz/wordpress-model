<?php # -*- coding: utf-8 -*-
// phpcs:disable

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
    public function testInstance()
    {
        $bem = $this->createMock(Service::class);
        $source = $this->createMock(Source::class);
        $alternativeText = $this->createMock(AlternativeText::class);

        $testee = new Testee(
            $bem,
            $source,
            $alternativeText
        );

        self::assertInstanceOf(Testee::class, $testee);
    }

    public function testFilterGetAppliedWithCorrectData()
    {
        $bem = $this->createMock(Service::class);
        $source = $this->createMock(Source::class);
        $alternativeText = $this->createMock(AlternativeText::class);

        $alternativeText
            ->expects($this->once())
            ->method('text')
            ->willReturn('alt text');

        $imageBemValue = $this->createMock(Valuable::class);
        $bem
            ->expects($this->once())
            ->method('forElement')
            ->with('image')
            ->willReturn($imageBemValue);

        $testee = new Testee(
            $bem,
            $source,
            $alternativeText
        );

        Filters\expectApplied(AttachmentImage::FILTER_DATA)
            ->once()
            ->with([
                'image' => [
                    'attributes' => [
                        'url' => '',
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

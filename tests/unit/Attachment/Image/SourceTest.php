<?php # -*- coding: utf-8 -*-
// phpcs:disable

namespace WordPressModel\Tests\Unit\Attachment\Image;

use Brain\Monkey;
use ProjectTestsHelper\Phpunit\TestCase;
use WordPressModel\Attachment\Image\Size;
use WordPressModel\Attachment\Image\Source as Testee;

class SourceTest extends TestCase
{
    /**
     * @expectedException \WordPressModel\Exception\InvalidAttachmentType
     */
    public function testCreationThrowInvalidAttachmentTypeExceptionIfAttachmentIsNotAnImage()
    {
        $attachment = $this
            ->getMockBuilder('WP_Post')
            ->getMock();
        $attachment->ID = 1;
        $size = $this->createMock(Size::class);

        Monkey\Functions\expect('wp_attachment_is_image')
            ->andReturn(false);

        new Testee($attachment, $size);
    }

    public function testCreationCallWpGetAttachmentImageSrc()
    {
        $attachment = $this
            ->getMockBuilder('WP_Post')
            ->getMock();
        $attachment->ID = 1;
        $size = $this->createMock(Size::class);

        Monkey\Functions\when('wp_attachment_is_image')
            ->justReturn(true);

        // Return a value just to prevent Exception. Not Interested in test it here.
        // Just ensure the values are evaluated as true.
        Monkey\Functions\expect('wp_get_attachment_image_src')
            ->once()
            ->with(1, 'string_type')
            ->andReturn(['url', 1, 1, true]);

        $size
            ->expects($this->atLeast(1))
            ->method('value')
            ->willReturn('string_type');

        new Testee($attachment, $size);
    }

    /**
     * @expectedException \DomainException
     * @dataProvider provideArrayWithFalseEvaluableItems
     */
    public function testDomainExceptionIsThrownIfWpGetAttachmentImageSrcReturnIncorrectValue(
        $source
    ) {

        $attachment = $this
            ->getMockBuilder('WP_Post')
            ->getMock();
        $attachment->ID = 1;
        $size = $this->createMock(Size::class);

        Monkey\Functions\when('wp_attachment_is_image')
            ->justReturn(true);

        Monkey\Functions\expect('wp_get_attachment_image_src')
            ->once()
            ->andReturn($source);

        new Testee($attachment, $size);
    }

    public function testsIntermediatePropertyGetFalseAsDefaultIfNotSet()
    {
        $attachment = $this
            ->getMockBuilder('WP_Post')
            ->getMock();
        $attachment->ID = 1;
        $size = $this->createMock(Size::class);

        Monkey\Functions\when('wp_attachment_is_image')
            ->justReturn(true);

        // Return a value just to prevent Exception. Not Interested in test it here.
        // Just ensure the values are evaluated as true.
        Monkey\Functions\when('wp_get_attachment_image_src')
            ->justReturn(['url', 1, 1]);

        $testee = new Testee($attachment, $size);

        self::assertFalse($testee->intermediate);
    }

    /**
     * Value returned depends on what is expected from `wp_get_attachment_image_src`
     *
     * @return array
     */
    public function provideArrayWithFalseEvaluableItems()
    {
        return [
            [false],
            [['', 0, 0]],
            [['', 0, 0, false]],
        ];
    }

    protected function setUp()
    {
        parent::setUp();

        class_alias(
            \WordPressModel\Exception\InvalidAttachmentType::class,
            \WordPressModel\Tests\Stubs\InvalidAttachmentType::class,
            true
        );
    }
}

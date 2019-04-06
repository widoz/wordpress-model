<?php # -*- coding: utf-8 -*-
// phpcs:disable

namespace WordPressModel\Tests\Unit\Attachment\Image;

use Brain\Monkey;
use ProjectTestsHelper\Phpunit\TestCase;
use WordPressModel\Attachment\Image\AlternativeText as Testee;

/**
 * Class AlternativeTextTest
 * @package WordPressModel\Tests\Unit\Attachment\Image
 */
class AlternativeTextTest extends TestCase
{
    /**
     * Test instance of Testee is created without errors
     */
    public function testInstance(): void
    {
        $attachment = $this
            ->getMockBuilder('WP_Post')
            ->getMock();
        $attachment->ID = 1;

        $testee = new Testee();

        self::assertInstanceOf(Testee::class, $testee);
    }

    /**
     * Test text method get the alternate text from post meta and apply filter on it
     */
    public function testText(): void
    {
        $stringValue = '';
        $attachment = $this
            ->getMockBuilder('WP_Post')
            ->getMock();
        $attachment->ID = 1;

        $testee = new Testee();

        Monkey\Functions\expect('get_post_meta')
            ->once()
            ->with(1, '_wp_attachment_image_alt', true)
            ->andReturn($stringValue);

        // Value doesn't matter, expect a generic string
        Monkey\Filters\expectApplied(Testee::FILTER_ALT)
            ->once()
            ->with($stringValue, $attachment);

        $testee->text($attachment);

        self::assertTrue(true);
    }
}

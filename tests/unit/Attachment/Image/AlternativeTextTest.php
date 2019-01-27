<?php # -*- coding: utf-8 -*-
// phpcs:disable

namespace WordPressModel\Tests\Unit\Attachment\Image;

use Brain\Monkey;
use ProjectTestsHelper\Phpunit\TestCase;
use WordPressModel\Attachment\Image\AlternativeText as Testee;

class AlternativeTextTest extends TestCase
{
    public function testInstance()
    {
        $attachment = $this
            ->getMockBuilder('WP_Post')
            ->getMock();
        $attachment->ID = 1;

        $testee = new Testee($attachment);

        self::assertInstanceOf(Testee::class, $testee);
    }

    public function testText()
    {
        $stringValue = '';
        $attachment = $this
            ->getMockBuilder('WP_Post')
            ->getMock();
        $attachment->ID = 1;

        $testee = new Testee($attachment);

        Monkey\Functions\expect('get_post_meta')
            ->once()
            ->with(1, '_wp_attachment_image_alt', true)
            ->andReturn($stringValue);

        // Value doesn't matter, expect a generic string
        Monkey\Filters\expectApplied(Testee::FILTER_ALT)
            ->once()
            ->with($stringValue, $attachment);

        $testee->text();

        self::assertTrue(true);
    }
}

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

namespace WordPressModel\Attachment;

use Brain\Monkey\Functions;
use Brain\Monkey\Filters;
use WordPressModel\Attachment\Caption as Testee;
use ProjectTestsHelper\Phpunit\TestCase;

/**
 * Class CaptionTest
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class CaptionTest extends TestCase
{
    /**
     * Test Caption
     */
    public function testCaption()
    {
        $expectedCaption = 'Caption';
        $attachment = $this
            ->getMockBuilder('WP_Post')
            ->getMock();
        $testee = new Testee();

        $attachment->ID = 1;
        $attachment->post_type = 'attachment';

        Functions\expect('wp_get_attachment_caption')
            ->once()
            ->with($attachment->ID)
            ->andReturn($expectedCaption);

        Filters\expectApplied(Testee::FILTER)
            ->once()
            ->with($expectedCaption, $attachment);

        $testee($attachment);

        self::assertTrue(true);
    }
}

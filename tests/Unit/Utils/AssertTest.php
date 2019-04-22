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

namespace WordPressModel\Utils;

use ProjectTestsHelper\Phpunit\TestCase;
use WordPressModel\Utils\Assert as Testee;
use InvalidArgumentException;

/**
 * Class AssertTest
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class AssertTest extends TestCase
{
    /**
     * Test WP_Post Instance is an Attachment Throw InvalidArgumentException
     */
    public function testIsAttachmentThrowInvalidArgumentException()
    {
        $post = $this->getMockBuilder('WP_Post')->getMock();
        $post->post_type = 'non_attachment_post_type';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            "Expected Post be an Attachment. Type of {$post->post_type} Given."
        );

        Testee::isAttachment($post);
    }
}

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

use InvalidArgumentException;
use Webmozart\Assert\Assert as WebMozartAssert;
use WP_Post;

/**
 * Class Assert
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
final class Assert extends WebMozartAssert
{
    /**
     * Assert a WP_Post Entity is an Attachment
     *
     * @param WP_Post $post
     * @param string|null $message
     * @throws InvalidArgumentException
     */
    public static function isAttachment(WP_Post $post, string $message = null): void
    {
        $postType = $post->post_type;
        'attachment' === $postType or static::reportInvalidArgument(
            $message ?: "Expected Post be an Attachment. Type of {$postType} Given."
        );
    }
}

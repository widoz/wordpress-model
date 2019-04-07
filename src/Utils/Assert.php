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

use function is_attachment;
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
     * Assert all Values Within the Given map are string types
     *
     * @param array $array
     * @param string|null $message
     * @throws \InvalidArgumentException
     */
    public static function isStringValueMap(array $array, string $message = null): void
    {
        static::isMap($array, $message);

        $isString = \array_filter($array, '\is_string');

        if (!$isString) {
            static::reportInvalidArgument(
                $message ?: 'Expect map of strings - All values of map are strings.'
            );
        }
    }

    /**
     * Assert Given Array Contains give Item
     *
     * @param $needle
     * @param array $haystack
     * @param string|null $message
     * @throws \InvalidArgumentException
     */
    public static function arrayContains($needle, array $haystack, string $message = null): void
    {
        if (!\in_array($needle, $haystack, true)) {
            static::reportInvalidArgument(
                $message ?: 'Expect item in array.'
            );
        }
    }

    /**
     * Assert a WP_Post Entity is an Attachment
     *
     * @param WP_Post $post
     * @param string|null $message
     * @throws \InvalidArgumentException
     */
    public static function isAttachment(WP_Post $post, string $message = null): void
    {
        'attachment' === $post->post_type or static::reportInvalidArgument(
            $message ?: 'Expected Post be an Attachment.'
        );
    }
}

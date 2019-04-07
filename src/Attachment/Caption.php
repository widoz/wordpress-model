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

use InvalidArgumentException;
use WordPressModel\Utils\Assert;
use WP_Post;
use function wp_get_attachment_caption;

/**
 * Class Caption
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class Caption
{
    public const FILTER = 'wordpressmodel.caption_text';

    /**
     * @param WP_Post $attachment
     * @return string
     * @throws InvalidArgumentException
     */
    public function __invoke(WP_Post $attachment): string
    {
        Assert::isAttachment($attachment);

        $caption = (string)wp_get_attachment_caption($attachment->ID);

        /**
         * Filter Caption
         *
         * @param string $caption The caption for the image.
         * @param WP_Post $attachment The attachment post.
         */
        $caption = apply_filters(self::FILTER, $caption, $attachment);

        return (string)$caption;
    }
}

<?php # -*- coding: utf-8 -*-

/*
 * This file is part of the wordpress-model package.
 *
 * (c) Guido Scialfa <dev@guidoscialfa.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace WordPressModel\Attachment\Image;

use WP_Post;

/**
 * Attachment Image AlternativeText
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class AlternativeText
{
    public const FILTER_ALT = 'wordpressmodel.attachment_image_alt';
    private const META_DATA_POST_KEY = '_wp_attachment_image_alt';

    /**
     * @param \WP_Post $attachment
     * @return string
     * @throws \InvalidArgumentException
     */
    public function text(WP_Post $attachment): string
    {
        $alt = \get_post_meta($attachment->ID, self::META_DATA_POST_KEY, true);

        /**
         * Filter Alt Attribute Value
         *
         * @param string $alt The alternative text.
         * @param \WP_Post $attachment The attachment object
         */
        $alt = apply_filters(self::FILTER_ALT, $alt, $attachment);

        return (string)$alt;
    }
}

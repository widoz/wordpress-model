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
     * @var \WP_Post
     */
    private $attachment;

    /**
     * AttachmentImageAlternativeDescription constructor
     * @param \WP_Post $attachment
     */
    public function __construct(\WP_Post $attachment)
    {
        $this->attachment = $attachment;
    }

    /**
     * @return string
     */
    public function text(): string
    {
        $alt = \get_post_meta($this->attachment->ID, self::META_DATA_POST_KEY, true);

        /**
         * Filter Alt Attribute Value
         *
         * @param string $alt The alternative text.
         * @param \WP_Post $attachment The attachment object
         */
        $alt = apply_filters(self::FILTER_ALT, $alt, $this->attachment);

        return (string)$alt;
    }
}

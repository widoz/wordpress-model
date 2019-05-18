<?php # -*- coding: utf-8 -*-

/*
 * This file is part of the WordPress Theme Model package.
 *
 * (c) Guido Scialfa <dev@guidoscialfa.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace WordPressModel\Model;

use function current_theme_supports;
use function get_permalink;
use function has_post_thumbnail;
use WP_Post;

/**
 * Post Thumbnail Model
 */
class PostThumbnail implements PartialModel
{
    public const FILTER_DATA = 'wordpressmodel.template_post_thumbnail_data';
    public const FILTER_PERMALINK = 'wordpressmodel.template_post_thumbnail_permalink';

    /**
     * @var WP_Post
     */
    private $post;

    /**
     * @var AttachmentImage
     */
    private $attachmentImage;

    /**
     * PostThumbnail constructor
     * @param WP_Post $post
     * @param AttachmentImage $attachmentImage
     */
    public function __construct(WP_Post $post, AttachmentImage $attachmentImage)
    {
        $this->post = $post;
        $this->attachmentImage = $attachmentImage;
    }

    /**
     * @inheritdoc
     */
    public function data(): array
    {
        $data = [];

        if ($this->hasThumbnail()) {
            /**
             * Post Thumbnail Data
             *
             * @param array Figure Model Data.
             */
            $data += [
                'link' => [
                    'attributes' => [
                        'href' => $this->permalink(),
                    ],
                ],
            ];

            $data += $this->attachmentImage->data();
        }

        /**
         * Post Thumbnail Data
         *
         * @param array Figure Model Data.
         */
        return apply_filters(self::FILTER_DATA, $data);
    }

    /**
     * @return string
     */
    protected function permalink(): string
    {
        $permalink = get_permalink($this->post);

        /**
         * Filter Post Thumbnail Permalink
         *
         * @param string $permalink The post permalink.
         */
        $permalink = apply_filters(self::FILTER_PERMALINK, $permalink);

        return (string)$permalink;
    }

    /**
     * Post Thumbnail Exists?
     *
     * @return bool
     */
    protected function hasThumbnail(): bool
    {
        return current_theme_supports('post-thumbnails') && has_post_thumbnail($this->post);
    }
}

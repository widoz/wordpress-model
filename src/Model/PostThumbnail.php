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

use Widoz\Bem\Service as ServiceBem;

/**
 * Post Thumbnail Model
 */
final class PostThumbnail implements PartialModel
{
    public const FILTER_DATA = 'wordpressmodel.template_post_thumbnail_data';
    public const FILTER_PERMALINK = 'wordpressmodel.template_post_thumbnail_permalink';

    /**
     * @var ServiceBem
     */
    private $bem;

    /**
     * @var \WP_Post
     */
    private $post;

    /**
     * @var string
     */
    private $attachmentSize;

    /**
     * PostThumbnail constructor
     * @param ServiceBem $bem
     * @param \WP_Post $post
     * @param string $attachmentSize
     */
    public function __construct(
        ServiceBem $bem,
        \WP_Post $post,
        string $attachmentSize = 'post-thumbnail'
    ) {

        $this->bem = $bem;
        $this->post = $post;
        $this->attachmentSize = $attachmentSize;
    }

    /**
     * @inheritdoc
     */
    public function data(): array
    {
        $data = [];

        if ($this->hasSupport() && $this->hasThumbnail()) {
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

            $data += $this->figureAttachmentModel()->data();
        }

        /**
         * Post Thumbnail Data
         *
         * @param array Figure Model Data.
         */
        return apply_filters(self::FILTER_DATA, $data);
    }

    /**
     * @return bool
     */
    private function hasSupport(): bool
    {
        return \current_theme_supports('post-thumbnails');
    }

    /**
     * @return bool
     */
    private function hasThumbnail(): bool
    {
        return \has_post_thumbnail($this->post);
    }

    /**
     * @return FigureAttachmentImage
     */
    private function figureAttachmentModel(): FigureAttachmentImage
    {
        return new FigureAttachmentImage(
            $this->bem,
            \get_post_thumbnail_id($this->post),
            $this->attachmentSize
        );
    }

    /**
     * @return string
     */
    private function permalink(): string
    {
        $permalink = \get_permalink($this->post);

        /**
         * Filter Post Thumbnail Permalink
         *
         * @param string $permalink The post permalink.
         */
        $permalink = apply_filters(self::FILTER_PERMALINK, $permalink);

        return (string)$permalink;
    }
}

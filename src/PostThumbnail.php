<?php # -*- coding: utf-8 -*-

/*
 * This file is part of the WordPress Theme Model Theme package.
 *
 * (c) Guido Scialfa <dev@guidoscialfa.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace WordPressModel;

use Widoz\Bem\Bem;
use Widoz\Bem\BemPrefixed;

/**
 * Post Thumbnail Model
 */
final class PostThumbnail implements Model
{
    public const FILTER_DATA = 'wordpressmodel.template_post_thumbnail_data';
    public const FILTER_PERMALINK = 'wordpressmodel.template_post_thumbnail_permalink';

    /**
     * @var \WP_Post
     */
    private $post;

    /**
     * @var string
     */
    private $attachmentSize;

    /**
     * PostThumbnail constructor.
     *
     * @param \WP_Post $post
     * @param string $attachmentSize
     */
    public function __construct(\WP_Post $post, string $attachmentSize = 'post-thumbnail')
    {
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
            $bem = new BemPrefixed('thumbnail');

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

            $data += $this->figureAttachmentModel($bem)->data();
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
        return current_theme_supports('post-thumbnails');
    }

    /**
     * @return bool
     */
    private function hasThumbnail(): bool
    {
        return has_post_thumbnail($this->post);
    }

    /**
     * @param Bem $bem
     *
     * @return FigureAttachmentImage
     */
    private function figureAttachmentModel(Bem $bem): FigureAttachmentImage
    {
        return new FigureAttachmentImage(
            get_post_thumbnail_id($this->post),
            $this->attachmentSize,
            $bem
        );
    }

    /**
     * @return string
     */
    private function permalink(): string
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
}

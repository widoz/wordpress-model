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

use function get_permalink;
use function get_the_title;
use Widoz\Bem\Service as ServiceBem;
use WP_Post;
use WP_Query;

/**
 * Post Title Model
 */
final class PostTitle implements PartialModel
{
    public const FILTER_DATA = 'wordpressmodel.post_title';

    /**
     * @var ServiceBem
     */
    private $bem;

    /**
     * @var WP_Post
     */
    private $post;

    /**
     * @var WP_Query
     */
    private $query;

    /**
     * PostTitle constructor.
     *
     * @param WP_Post $post
     * @param WP_Query $query
     */
    public function __construct(ServiceBem $bem, WP_Post $post, WP_Query $query)
    {
        $this->bem = $bem;
        $this->post = $post;
        $this->query = $query;
    }

    /**
     * @return array
     */
    public function data(): array
    {
        $isSingular = $this->query->is_singular();
        $href = $isSingular ? '' : (string)get_permalink($this->post);

        /**
         * Post Title
         *
         * @param array $data The data to inject into the template.
         * @param WP_Query $query The query associated with the post.
         */
        return apply_filters(self::FILTER_DATA, [
            'title' => [
                'text' => get_the_title($this->post),
                'attributes' => [
                    'class' => $this->bem->forElement('title'),
                ],
            ],
            'link' => [
                'attributes' => [
                    'class' => $this->bem->forElement('link'),
                    'href' => $href,
                ],
            ],
        ], $this->query);
    }
}

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

use WordPressModel\Attribute\ClassAttribute;
use Widoz\Bem\BemPrefixed;

/**
 * Post Title Model
 */
final class PostTitle implements Model
{
    const FILTER_DATA = 'wordpressmodel.post_title';

    /**
     * @var \WP_Post
     */
    private $post;

    /**
     * @var \WP_Query
     */
    private $query;

    /**
     * PostTitle constructor.
     *
     * @param \WP_Post $post
     * @param \WP_Query $query
     */
    public function __construct(\WP_Post $post, \WP_Query $query)
    {
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

        $titleClassAttribute = new ClassAttribute(new BemPrefixed('article', 'title'));
        $linkClassAttribute = new ClassAttribute(new BemPrefixed('article', 'link'));

        /**
         * Post Title
         *
         * @param array $data The data to inject into the template.
         * @param \WP_Query $query The query associated with the post.
         */
        return apply_filters(self::FILTER_DATA, [
            'title' => [
                'text' => $this->title(),
                'attributes' => [
                    'class' => $titleClassAttribute->value(),
                ],
            ],
            'link' => [
                'attributes' => [
                    'class' => $linkClassAttribute->value(),
                    'href' => $href,
                ],
            ],
        ], $this->query);
    }

    /**
     * @return string
     */
    private function title(): string
    {
        return get_the_title($this->post);
    }
}

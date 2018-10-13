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
 * Taxonomy Category Model
 */
final class Category implements Model
{
    const FILTER_DATA = 'wordpressmodel.post_category';

    /**
     * @var \WP_Post
     */
    private $post;

    /**
     * @var string
     */
    private static $taxonomy = 'category';

    /**
     * Category constructor.
     *
     * @param \WP_Post $post
     */
    public function __construct(\WP_Post $post)
    {
        $this->post = $post;
    }

    /**
     * @return array
     */
    public function data(): array
    {
        $taxonomoyClassAttribute = new ClassAttribute(new BemPrefixed('post-category'));
        $titleClassAttribute = new ClassAttribute(new BemPrefixed('post-category', 'title'));
        $categoryClassAttribute = new ClassAttribute(new BemPrefixed('terms'));

        /**
         * Category Filter
         *
         * @param array $category The post terms category to filter.
         */
        return apply_filters(self::FILTER_DATA, [
            'container' => [
                'attributes' => [
                    'class' => $taxonomoyClassAttribute->value(),
                ],
            ],
            'title' => [
                'text' => __('Posted In: ', 'wordpress-model'),
                'attributes' => [
                    'class' => $titleClassAttribute->value(),
                ],
            ],
            'terms' => [
                'items' => $this->terms()->data(),
                'attributes' => [
                    'class' => $categoryClassAttribute->value(),
                ],
            ],
        ]);
    }

    /**
     * @return Terms
     */
    private function terms(): Terms
    {
        return new Terms(self::$taxonomy, 'get_the_categories', [
            'object_ids' => [$this->post->ID],
        ]);
    }
}

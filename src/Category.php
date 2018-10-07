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
 * Post Category Model
 */
final class Category implements Model
{
    private const FILTER_DATA = 'wordpressmodel.template_data_post_category';

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
        $containerClass = new ClassAttribute(new BemPrefixed('post-category'));
        $labelClass = new ClassAttribute(new BemPrefixed('post-category', 'label'));
        $categoryClass = new ClassAttribute(new BemPrefixed('terms'));
        $terms = new Terms(self::$taxonomy, 'get_the_categories', [
            'object_ids' => [$this->post->ID],
        ]);

        /**
         * Category Filter
         *
         * @param array $category The post terms category to filter.
         */
        return apply_filters(self::FILTER_DATA, [
            'attributes' => [
                'class' => $containerClass->value(),
            ],
            'label' => [
                'text' => __('Posted In: ', 'wordpress-model'),
                'attributes' => [
                    'class' => $labelClass->value(),
                ],
            ],
            'terms' => [
                'items' => $terms->data(),
                'attributes' => [
                    'class' => $categoryClass->value(),
                ],
            ],
        ]);
    }
}

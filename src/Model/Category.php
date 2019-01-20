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

use Widoz\Bem\Factory;

/**
 * Taxonomy Category Model
 */
final class Category implements FullFilledModel
{
    public const FILTER_DATA = 'wordpressmodel.post_category';

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
        $bem = Factory::createServiceForStandard('category');

        /**
         * Category Filter
         *
         * @param array $category The post terms category to filter.
         */
        return apply_filters(self::FILTER_DATA, [
            'container' => [
                'attributes' => [
                    'class' => $bem->value(),
                ],
            ],
            'title' => [
                'text' => __('Posted In: ', 'wordpress-model'),
                'attributes' => [
                    'class' => $bem->forElement('title'),
                ],
            ],
            'terms' => [
                'items' => $this->terms()->data(),
                'attributes' => [
                    'class' => $bem->forElement('terms'),
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

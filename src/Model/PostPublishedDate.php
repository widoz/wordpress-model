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
 * Post Published Date Model
 */
final class PostPublishedDate implements FullFilledModel
{
    public const FILTER_DATA = 'wordpressmodel.post_published_date';

    /**
     * @var \WP_Post
     */
    private $post;

    /**
     * PostPublishedDate constructor.
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
        $bem = Factory::createServiceForStandard('article-published-date');
        $archiveLink = \get_day_link(
            \get_the_time('Y', $this->post),
            \get_the_time('m', $this->post),
            \get_the_time('d', $this->post)
        );

        /**
         * Post Published Data
         *
         * @param array $data The model.
         */
        return apply_filters(self::FILTER_DATA, [
            'container' => [
                'attributes' => [
                    'class' => $bem,
                ],
            ],
            'title' => [
                'text' => __('Published On', 'wordpress-model'),
            ],
            'link' => [
                'attributes' => [
                    'href' => $archiveLink,
                    'class' => $bem->forElement('link'),
                ],
            ],
            'time' => [
                'date' => \get_the_date('', $this->post),
                'attributes' => [
                    'datetime' => \get_the_time('c', $this->post),
                    'title' => \get_the_date('l, F j, Y g:i a', $this->post),
                ],
            ],
        ]);
    }
}

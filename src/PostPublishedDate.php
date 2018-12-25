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

namespace WordPressModel;

use WordPressModel\Attribute\ClassAttribute;
use Widoz\Bem\BemPrefixed;

/**
 * Post Published Date Model
 */
final class PostPublishedDate implements Model
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
        $archiveLink = get_day_link(
            get_the_time('Y', $this->post),
            get_the_time('m', $this->post),
            get_the_time('d', $this->post)
        );

        $containerClass = new ClassAttribute(new BemPrefixed('article-published-date'));
        $archiveLinkClass = new ClassAttribute(new BemPrefixed('article-published-date', 'link'));

        /**
         * Post Published Data
         *
         * @param array $data The model.
         */
        return apply_filters(self::FILTER_DATA, [
            'text' => __('Published On', 'wordpress-model'),
            'container' => [
                'attributes' => [
                    'class' => $containerClass->value(),
                ],
            ],
            'link' => [
                'attributes' => [
                    'href' => $archiveLink,
                    'class' => $archiveLinkClass->value(),
                ],
            ],
            'time' => [
                'date' => get_the_date('', $this->post),
                'attributes' => [
                    'datetime' => get_the_time('c', $this->post),
                    'title' => get_the_date('l, F j, Y g:i a', $this->post),
                ],
            ],
        ]);
    }
}
